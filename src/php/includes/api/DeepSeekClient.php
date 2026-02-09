<?php
namespace CVGen\Api;

/**
 * HTTP client for the DeepSeek API (OpenAI-compatible format).
 *
 * Handles authentication, request formatting, and response parsing.
 * All query classes should use this rather than calling cURL directly.
 */
class DeepSeekClient
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://api.deepseek.com/v1';

    public function __construct(?string $apiKey = null, string $model = 'deepseek-chat')
    {
        $this->apiKey = $apiKey ?? (getenv('DEEPSEEK_API_KEY') ?: '');
        $this->model = $model;

        if ($this->apiKey === '') {
            throw new \RuntimeException('DEEPSEEK_API_KEY is not configured');
        }
    }

    /**
     * Send a prompt to DeepSeek and return the text response.
     *
     * @param string      $prompt         The full prompt (system instructions + wrapped user data).
     * @param float       $temperature    Sampling temperature (0.0 – 2.0).
     * @param int         $maxTokens      Maximum output tokens.
     * @return array{text: string, usage: array}  Parsed response.
     * @throws \RuntimeException on network or API errors.
     */
    public function generate(
        string $prompt,
        float $temperature = 0.7,
        int $maxTokens = 4096
    ): array {
        $url = "{$this->baseUrl}/chat/completions";

        $payload = [
            'model'       => $this->model,
            'messages'    => [
                [
                    'role'    => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature'  => $temperature,
            'max_tokens'   => $maxTokens,
        ];

        $response = $this->post($url, $payload);

        // Extract text from OpenAI-compatible response structure
        $text = $response['choices'][0]['message']['content'] ?? '';

        $usage = $response['usage'] ?? [];

        return [
            'text'  => $text,
            'usage' => $usage,
        ];
    }

    /**
     * Low-level POST request via cURL.
     *
     * @return array Decoded JSON response body.
     */
    private function post(string $url, array $payload): array
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $raw = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($raw === false) {
            throw new \RuntimeException("cURL error: {$curlError}");
        }

        $decoded = json_decode($raw, true);

        if ($httpCode >= 400) {
            $message = $decoded['error']['message'] ?? "HTTP {$httpCode}";
            throw new \RuntimeException("DeepSeek API error: {$message}");
        }

        return $decoded ?? [];
    }
}
