<?php
namespace CVGen\Api\Queries;

use CVGen\Api\BaseQuery;

/**
 * Saves a generated CV to the database and optionally grades it.
 *
 * Expected input data:
 *  - cv_content (string, required): The HTML content of the generated CV.
 *  - job_target (string, optional): The job title the CV was tailored for.
 *  - job_id (int, optional): The job_id from job_listings table.
 *  - user_id (int, required): The user's ID (passed from session).
 *  - grade_cv (bool, optional): Whether to grade the CV and store the score.
 */
class SaveCVQuery extends BaseQuery
{
    protected float $temperature = 0.4;
    protected int $maxTokens = 2048;

    private ?\PDO $db = null;

    public function setDatabase(\PDO $db): void
    {
        $this->db = $db;
    }

    protected function validate(array $data): void
    {
        if (empty($data['cv_content'])) {
            throw new \InvalidArgumentException('Missing required field: cv_content');
        }
        if (empty($data['user_id'])) {
            throw new \InvalidArgumentException('Missing required field: user_id');
        }
    }

    protected function fieldLimits(): array
    {
        return [
            'cv_content' => 50000,
            'job_target' => 300,
        ];
    }

    protected function buildPrompt(array $cleanData): string
    {
        // Only used if grading is requested
        $sections = [];

        $sections[] = implode("\n", [
            'You are a professional CV reviewer.',
            'Analyse the CV provided and return ONLY a single integer score from 1 to 100.',
            'Consider formatting, content quality, relevance, and impact.',
            'Return ONLY the number, nothing else.',
        ]);

        $sections[] = $this->sanitizer->prepareField('CV Content', $cleanData['cv_content'], 50000);

        if (!empty($cleanData['job_target'])) {
            $sections[] = $this->sanitizer->prepareField('Target Job', $cleanData['job_target'], 300);
        }

        return implode("\n\n", $sections);
    }

    public function execute(array $data): array
    {
        $this->validate($data);

        // Sanitize user-supplied fields but preserve HTML in cv_content (AI-generated output)
        $cvContent = $data['cv_content'];
        unset($data['cv_content']);
        $clean = $this->sanitizer->cleanArray($data, $this->fieldLimits());
        $clean['cv_content'] = mb_substr($cvContent, 0, 50000);

        $score = null;
        $usage = null;

        // Grade the CV if requested
        if (!empty($data['grade_cv'])) {
            $prompt = $this->buildPrompt($clean);
            $raw = $this->ai->generate($prompt, $this->temperature, $this->maxTokens);

            // Extract numeric score
            $scoreText = trim($raw['text']);
            $score = (int) preg_replace('/[^0-9]/', '', $scoreText);
            if ($score < 1) $score = 1;
            if ($score > 100) $score = 100;

            $usage = $raw['usage'];
        }

        // Save to database
        if ($this->db === null) {
            throw new \RuntimeException('Database connection not available');
        }

        $cvData = [
            'content' => $clean['cv_content'],
            'job_target' => $clean['job_target'] ?? '',
            'score' => $score,
        ];

        $stmt = $this->db->prepare(
            'INSERT INTO cvs (user_id, job_id, content_json, score, job_target) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            (int) $data['user_id'],
            (int) ($data['job_id'] ?? 0),
            json_encode($cvData),
            $score,
            $clean['job_target'] ?? ''
        ]);

        $cvId = $this->db->lastInsertId();

        return [
            'cv_id' => (int) $cvId,
            'score' => $score,
            'usage' => $usage,
        ];
    }
}
