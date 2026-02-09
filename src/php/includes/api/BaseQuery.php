<?php
namespace CVGen\Api;

/**
 * Abstract base for all Gemini query types.
 *
 * To add a new query:
 *  1. Create a class in includes/api/queries/ that extends BaseQuery.
 *  2. Implement validate() and buildPrompt().
 *  3. Optionally override parseResponse() for custom post-processing.
 *  4. Register the action name → class name in api/router.php's $queryMap.
 */
abstract class BaseQuery
{
    protected DeepSeekClient $ai;
    protected InputSanitizer $sanitizer;

    // TODO: Add database property once DB integration is wired up
    // Use get_db() from includes/auth.php to obtain a PDO instance
    // protected \PDO $db;

    /** Sampling temperature – override per query if needed. */
    protected float $temperature = 0.7;

    /** Max output tokens – override per query if needed. */
    protected int $maxTokens = 4096;

    public function __construct(DeepSeekClient $ai, InputSanitizer $sanitizer)
    {
        $this->ai        = $ai;
        $this->sanitizer = $sanitizer;
    }

    /**
     * Main entry point called by the router.
     *
     * @param  array $data  Raw user-supplied data from the request body.
     * @return array        The result to send back to the client.
     */
    public function execute(array $data): array
    {
        // 1. Validate required fields
        $this->validate($data);

        // 2. Sanitize all input
        $clean = $this->sanitizer->cleanArray($data, $this->fieldLimits());

        // 3. Build the prompt (system instructions + wrapped user data)
        $prompt = $this->buildPrompt($clean);

        // 4. Call DeepSeek
        $raw = $this->ai->generate($prompt, $this->temperature, $this->maxTokens);

        // 5. Log the call
        // TODO: Log API call to chats table once DB integration is ready
        // $db = get_db();
        // $stmt = $db->prepare('INSERT INTO chats (user_id, questions, answers) VALUES (?, ?, ?)');
        // $stmt->execute([$userId, $prompt, $raw['text']]);

        // 6. Post-process
        return $this->parseResponse($raw, $clean);
    }

    /**
     * Validate that required fields are present and acceptable.
     * Throw \InvalidArgumentException on failure.
     */
    abstract protected function validate(array $data): void;

    /**
     * Build the full prompt string sent to Gemini.
     * Use $this->sanitizer->prepareField() to wrap each user-data section.
     */
    abstract protected function buildPrompt(array $cleanData): string;

    /**
     * Optional per-field character limits passed to the sanitizer.
     * Override to tighten limits for specific fields.
     *
     * @return array<string, int>
     */
    protected function fieldLimits(): array
    {
        return [];
    }

    /**
     * Post-process the Gemini response into the array returned to the client.
     * Override for custom parsing (e.g. JSON extraction).
     */
    protected function parseResponse(array $raw, array $cleanData): array
    {
        return [
            'content' => $raw['text'],
            'usage'   => $raw['usage'],
        ];
    }
}
