<?php
namespace CVGen\Api;

/**
 * HTTP client for the Google Gemini API.
 *
 * Handles authentication, request formatting, and response parsing.
 * All query classes should use this rather than calling cURL directly.
 */
class GeminiClient
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct(?string $apiKey = null, string $model = 'gemini-2.0-flash')
    {
        $this->apiKey = $apiKey ?? (getenv('GEMINI_API_KEY') ?: '');
        $this->model = $model;

        if ($this->apiKey === '' || $this->apiKey === getenv()) {
            throw new \RuntimeException('GEMINI_API_KEY is not configured');
        }
    }

    /**
     * Send a prompt to Gemini and return the text response.
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
        $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature'     => $temperature,
                'maxOutputTokens' => $maxTokens,
            ],
        ];

        $response = $this->post($url, $payload);

        // Extract text from Gemini response structure
        $text = $response['candidates'][0]['content']['parts'][0]['text']
            ?? '';

        $usage = $response['usageMetadata'] ?? [];

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
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
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
            throw new \RuntimeException("Gemini API error: {$message}");
        }

        return $decoded ?? [];
    }
}
