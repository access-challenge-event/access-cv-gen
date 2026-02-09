<?php
namespace CVGen\Api\Queries;

use CVGen\Api\BaseQuery;

/**
 * Grades the user's interview answers against the model answers
 * returned by GenerateInterviewQuestionsQuery.
 *
 * Expected input data:
 *  - role (string, required): The job title the questions were generated for.
 *  - questions (array, required): Array of objects, each containing:
 *      - question (string): The interview question.
 *      - model_answer (string): The example answer from the generation step.
 *      - user_answer (string): The user's own answer to grade.
 *
 * Returns JSON array of graded results per question.
 */
class GradeInterviewAnswersQuery extends BaseQuery
{
    protected float $temperature = 0.3; // Low temp for consistent grading
    protected int $maxTokens = 4096;

    protected function validate(array $data): void
    {
        if (empty($data['role'])) {
            throw new \InvalidArgumentException('Missing required field: role');
        }
        if (empty($data['questions']) || !is_array($data['questions'])) {
            throw new \InvalidArgumentException('Missing required field: questions (must be an array)');
        }

        foreach ($data['questions'] as $i => $q) {
            if (empty($q['question'])) {
                throw new \InvalidArgumentException("Question at index {$i} is missing the 'question' field");
            }
            if (empty($q['model_answer'])) {
                throw new \InvalidArgumentException("Question at index {$i} is missing the 'model_answer' field");
            }
            if (!isset($q['user_answer']) || trim($q['user_answer']) === '') {
                throw new \InvalidArgumentException("Question at index {$i} is missing the 'user_answer' field");
            }
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
            'You are an expert interview coach grading a candidate\'s interview answers.',
            'For each question below you are given:',
            '  - The interview question',
            '  - A model answer (the ideal response)',
            '  - The candidate\'s actual answer',
            '',
            'Grade each answer and return a JSON array with this exact structure:',
            '[',
            '  {',
            '    "question_number": 1,',
            '    "score": <1-10>,',
            '    "feedback": "Specific feedback explaining the score",',
            '    "strengths": ["What the candidate did well"],',
            '    "improvements": ["What could be improved"]',
            '  }',
            ']',
            '',
            'After all individual grades, also include a final summary object as the last element:',
            '{',
            '  "question_number": "summary",',
            '  "overall_score": <1-100>,',
            '  "overall_feedback": "Brief overall assessment of interview readiness",',
            '  "top_strengths": ["..."],',
            '  "priority_improvements": ["..."]',
            '}',
            '',
            'Scoring guide:',
            '  1-3: Poor — answer is missing key points or incorrect',
            '  4-5: Below average — partially addresses the question',
            '  6-7: Good — covers the main points adequately',
            '  8-9: Very good — thorough, well-structured answer',
            '  10: Excellent — could not be meaningfully improved',
            '',
            'Return ONLY valid JSON. No markdown fences, no extra text.',
        ]);

        $sections[] = $this->sanitizer->prepareField('Target Role', $cleanData['role'], 200);

        foreach ($cleanData['questions'] as $i => $q) {
            $num = $i + 1;
            $question    = $this->sanitizer->clean($q['question'] ?? '', 1000);
            $modelAnswer = $this->sanitizer->clean($q['model_answer'] ?? '', 3000);
            $userAnswer  = $this->sanitizer->clean($q['user_answer'] ?? '', 3000);

            $block = implode("\n", [
                "Question {$num}: {$question}",
                "",
                "Model answer: {$modelAnswer}",
                "",
                "Candidate answer: {$userAnswer}",
            ]);

            $sections[] = $this->sanitizer->wrapAsData("Interview Question {$num}", $block);
        }

        return implode("\n\n", $sections);
    }

    protected function parseResponse(array $raw, array $cleanData): array
    {
        $text = trim($raw['text']);

        // Strip markdown code fences if present
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);

        $decoded = json_decode($text, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // Separate individual grades from summary
            $grades = [];
            $summary = null;

            foreach ($decoded as $item) {
                if (($item['question_number'] ?? '') === 'summary') {
                    $summary = $item;
                } else {
                    $grades[] = $item;
                }
            }

            return [
                'role'    => $cleanData['role'],
                'grades'  => $grades,
                'summary' => $summary,
                'usage'   => $raw['usage'],
            ];
        }

        return [
            'role'    => $cleanData['role'],
            'grades'  => null,
            'raw'     => $text,
            'usage'   => $raw['usage'],
        ];
    }
}
