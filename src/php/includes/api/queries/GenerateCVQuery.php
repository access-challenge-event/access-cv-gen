<?php
namespace CVGen\Api\Queries;

use CVGen\Api\BaseQuery;

/**
 * Generates a new professional CV from user-supplied personal data.
 *
 * Expected input data:
 *  - name (string, required)
 *  - email (string, required)
 *  - phone (string, optional)
 *  - summary (string, optional): Brief professional summary / personal statement.
 *  - experience (array, optional): List of { job_title, company, start_date, end_date, description }.
 *  - education (array, optional): List of { institution, degree, field, graduation_date }.
 *  - awards (array, optional): List of { title, description }.
 *  - skills (array, optional): List of skill strings.
 *  - existing_cv (string, optional): Text of an uploaded CV to use as a base.
 *  - job_target (string, optional): The role the CV should be tailored for.
 */
class GenerateCVQuery extends BaseQuery
{
    protected float $temperature = 0.6;
    protected int $maxTokens = 8192;

    protected function validate(array $data): void
    {
        if (empty($data['name'])) {
            throw new \InvalidArgumentException('Missing required field: name');
        }
        if (empty($data['email'])) {
            throw new \InvalidArgumentException('Missing required field: email');
        }
    }

    protected function fieldLimits(): array
    {
        return [
            'name'        => 200,
            'email'       => 254,
            'phone'       => 30,
            'summary'     => 2000,
            'existing_cv' => 10000,
            'job_target'  => 300,
        ];
    }

    protected function buildPrompt(array $cleanData): string
    {
        $sections = [];

        // System instructions
        $sections[] = implode("\n", [
            'You are a professional CV writer.',
            'Using ONLY the personal data provided below, create a polished, well-structured CV.',
            'Do NOT invent any facts, qualifications, or experience that are not present in the data.',
            'If an uploaded CV is included, use it as additional context but improve the language and structure.',
            'Return the CV as clean HTML suitable for rendering (use <h2>, <h3>, <p>, <ul> tags).',
            'Do NOT include <html>, <head>, or <body> tags — only the inner content.',
        ]);

        // Wrapped user data sections
        $sections[] = $this->sanitizer->prepareField('Full Name', $cleanData['name'], 200);
        $sections[] = $this->sanitizer->prepareField('Email', $cleanData['email'], 254);

        if (!empty($cleanData['phone'])) {
            $sections[] = $this->sanitizer->prepareField('Phone', $cleanData['phone'], 30);
        }

        if (!empty($cleanData['summary'])) {
            $sections[] = $this->sanitizer->prepareField('Professional Summary', $cleanData['summary'], 2000);
        }

        if (!empty($cleanData['experience']) && is_array($cleanData['experience'])) {
            $expText = $this->formatExperience($cleanData['experience']);
            $sections[] = $this->sanitizer->wrapAsData('Work Experience', $expText);
        }

        if (!empty($cleanData['education']) && is_array($cleanData['education'])) {
            $eduText = $this->formatEducation($cleanData['education']);
            $sections[] = $this->sanitizer->wrapAsData('Education', $eduText);
        }

        if (!empty($cleanData['awards']) && is_array($cleanData['awards'])) {
            $awardsText = $this->formatAwards($cleanData['awards']);
            $sections[] = $this->sanitizer->wrapAsData('Awards & Achievements', $awardsText);
        }

        if (!empty($cleanData['skills']) && is_array($cleanData['skills'])) {
            $skillList = implode(', ', array_map(
                fn($s) => $this->sanitizer->clean(is_string($s) ? $s : '', 100),
                $cleanData['skills']
            ));
            $sections[] = $this->sanitizer->wrapAsData('Skills', $skillList);
        }

        if (!empty($cleanData['existing_cv'])) {
            $sections[] = $this->sanitizer->prepareField('Uploaded CV Text', $cleanData['existing_cv'], 10000);
        }

        if (!empty($cleanData['job_target'])) {
            $sections[] = $this->sanitizer->prepareField('Target Job Role', $cleanData['job_target'], 300);
        }

        return implode("\n\n", $sections);
    }

    private function formatExperience(array $items): string
    {
        $lines = [];
        foreach ($items as $exp) {
            $title   = $this->sanitizer->clean($exp['job_title'] ?? '', 200);
            $company = $this->sanitizer->clean($exp['company'] ?? '', 200);
            $start   = $this->sanitizer->clean($exp['start_date'] ?? '', 20);
            $end     = $this->sanitizer->clean($exp['end_date'] ?? 'Present', 20);
            $desc    = $this->sanitizer->clean($exp['description'] ?? '', 2000);

            $lines[] = "- {$title} at {$company} ({$start} – {$end}): {$desc}";
        }
        return implode("\n", $lines);
    }

    private function formatEducation(array $items): string
    {
        $lines = [];
        foreach ($items as $edu) {
            $inst  = $this->sanitizer->clean($edu['institution'] ?? '', 200);
            $deg   = $this->sanitizer->clean($edu['degree'] ?? '', 200);
            $field = $this->sanitizer->clean($edu['field'] ?? '', 200);
            $date  = $this->sanitizer->clean($edu['graduation_date'] ?? '', 20);

            $lines[] = "- {$deg} in {$field} from {$inst} ({$date})";
        }
        return implode("\n", $lines);
    }

    private function formatAwards(array $items): string
    {
        $lines = [];
        foreach ($items as $award) {
            $title = $this->sanitizer->clean($award['title'] ?? '', 200);
            $desc  = $this->sanitizer->clean($award['description'] ?? '', 500);

            $lines[] = "- {$title}: {$desc}";
        }
        return implode("\n", $lines);
    }

    protected function parseResponse(array $raw, array $cleanData): array
    {
        $text = $raw['text'];

        // Strip markdown code fences that LLMs commonly wrap HTML in
        $text = preg_replace('/^```(?:html)?\s*\n?/i', '', $text);
        $text = preg_replace('/\n?```\s*$/', '', $text);
        $text = trim($text);

        return [
            'content' => $text,
            'usage'   => $raw['usage'],
        ];
    }
}
