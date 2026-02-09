<?php
namespace CVGen\Api\Queries;

use CVGen\Api\BaseQuery;

/**
 * Generates 10 mock interview questions for a given role,
 * each with a model answer that can later be used for grading.
 *
 * Expected input data:
 *  - role (string, required): The job title / role the user is preparing for.
 *
 * Returns JSON array of 10 objects:
 *  { "question": "...", "answer": "..." }
 */
class GenerateInterviewQuestionsQuery extends BaseQuery
{
    protected float $temperature = 0.7;
    protected int $maxTokens = 4096;

    protected function validate(array $data): void
    {
        if (empty($data['role'])) {
            throw new \InvalidArgumentException('Missing required field: role');
        }
    }

    protected function fieldLimits(): array
    {
        return [
            'role' => 200,
        ];
    }

    protected function buildPrompt(array $cleanData): string
    {
        $sections = [];

        $sections[] = implode("\n", [
            'You are an expert interview coach.',
            'Generate exactly 10 mock interview questions that are typical for the role specified below.',
            'For each question, provide a strong example answer that would be considered acceptable in a real interview.',
            'Return your response as a JSON array with this exact structure:',
            '[',
            '  {',
            '    "question_number": 1,',
            '    "question": "The interview question",',
            '    "answer": "A strong example answer that demonstrates competence"',
            '  }',
            ']',
            'Include a mix of:',
            '- Behavioural questions (e.g. "Tell me about a time...")',
            '- Technical or role-specific questions',
            '- Situational questions',
            '- General competency questions',
            'Return ONLY valid JSON. No markdown fences, no extra text.',
        ]);

        $sections[] = $this->sanitizer->prepareField('Target Role', $cleanData['role'], 200);

        return implode("\n\n", $sections);
    }

    protected function parseResponse(array $raw, array $cleanData): array
    {
        $text = trim($raw['text']);

        // Strip markdown code fences if the model wraps them anyway
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);

        $decoded = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return [
                'role'      => $cleanData['role'],
                'questions' => $decoded,
                'usage'     => $raw['usage'],
            ];
        }

        return [
            'role'      => $cleanData['role'],
            'questions' => null,
            'raw'       => $text,
            'usage'     => $raw['usage'],
        ];
    }
}
