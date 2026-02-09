<?php
namespace CVGen\Api\Queries;

use CVGen\Api\BaseQuery;

/**
 * Grades an existing CV and returns structured feedback.
 *
 * Expected input data:
 *  - cv_text (string, required): The full text of the CV to grade.
 *  - job_title (string, optional): Target role for context.
 */
class GradeCVQuery extends BaseQuery
{
    protected float $temperature = 0.4;

    protected function validate(array $data): void
    {
        if (empty($data['cv_text'])) {
            throw new \InvalidArgumentException('Missing required field: cv_text');
        }
    }

    protected function fieldLimits(): array
    {
        return [
            'cv_text'   => 10000,
            'job_title' => 200,
        ];
    }

    protected function buildPrompt(array $cleanData): string
    {
        $sections = [];

        // System instructions (not user data — these are trusted)
        $sections[] = implode("\n", [
            'You are a professional CV reviewer.',
            'Analyse the CV provided in the USER DATA section below.',
            'Return your assessment as JSON with this exact structure:',
            '{',
            '  "overall_score": <1-100>,',
            '  "sections": {',
            '    "formatting":       { "score": <1-10>, "feedback": "..." },',
            '    "content":          { "score": <1-10>, "feedback": "..." },',
            '    "relevance":        { "score": <1-10>, "feedback": "..." },',
            '    "impact":           { "score": <1-10>, "feedback": "..." }',
            '  },',
            '  "strengths": ["..."],',
            '  "improvements": ["..."],',
            '  "summary": "..."',
            '}',
            'Return ONLY valid JSON. No markdown fences, no extra text.',
        ]);

        // Wrapped user data
        $sections[] = $this->sanitizer->prepareField('CV Text', $cleanData['cv_text'], 10000);

        if (!empty($cleanData['job_title'])) {
            $sections[] = $this->sanitizer->prepareField('Target Job Title', $cleanData['job_title'], 200);
        }

        return implode("\n\n", $sections);
    }

    protected function parseResponse(array $raw, array $cleanData): array
    {
        $text = trim($raw['text']);

        // Try to decode as JSON for structured output
        $decoded = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return [
                'grade' => $decoded,
                'usage' => $raw['usage'],
            ];
        }

        // Fallback: return raw text if the model didn't produce valid JSON
        return [
            'grade' => null,
            'raw'   => $text,
            'usage' => $raw['usage'],
        ];
    }
}
