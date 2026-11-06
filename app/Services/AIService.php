<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('ai.openai_api_key');
        $this->baseUrl = config('ai.openai_base_url', 'https://api.openai.com/v1');
        $this->model = config('ai.default_model', 'gpt-3.5-turbo');
    }

    /**
     * Generate content using AI
     */
    public function generateContent(string $prompt, array $options = []): array
    {
        $cacheKey = 'ai_generated_' . md5($prompt . serialize($options));
        
        return Cache::remember($cacheKey, config('ai.cache_ttl', 3600), function () use ($prompt, $options) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post($this->baseUrl . '/chat/completions', [
                    'model' => $options['model'] ?? $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $this->getSystemPrompt($options['type'] ?? 'general')
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => $options['max_tokens'] ?? 1000,
                    'temperature' => $options['temperature'] ?? 0.7,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'success' => true,
                        'content' => $data['choices'][0]['message']['content'] ?? '',
                        'usage' => $data['usage'] ?? null,
                    ];
                }

                return [
                    'success' => false,
                    'error' => 'API request failed: ' . $response->body(),
                ];
            } catch (\Exception $e) {
                Log::error('AI Service Error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'error' => 'Service temporarily unavailable',
                ];
            }
        });
    }

    /**
     * Generate blog post content
     */
    public function generateBlogPost(array $params): array
    {
        $prompt = "Write a comprehensive blog post about: {$params['topic']}";
        
        if (isset($params['tone'])) {
            $prompt .= " in a {$params['tone']} tone";
        }
        
        if (isset($params['length'])) {
            $prompt .= ". The post should be approximately {$params['length']} words";
        }
        
        if (isset($params['target_audience'])) {
            $prompt .= " for {$params['target_audience']}";
        }
        
        if (isset($params['keywords'])) {
            $prompt .= ". Include these keywords naturally: " . implode(', ', $params['keywords']);
        }

        return $this->generateContent($prompt, [
            'type' => 'blog_post',
            'max_tokens' => 2000,
        ]);
    }

    /**
     * Generate SEO meta description
     */
    public function generateSEODescription(string $title, string $content, int $maxLength = 160): array
    {
        $prompt = "Generate a compelling SEO meta description for a page titled '{$title}'. 
                  Content summary: " . substr($content, 0, 500) . "
                  Requirements:
                  - Maximum {$maxLength} characters
                  - Include relevant keywords
                  - Compelling call-to-action
                  - No quotes or special characters";

        return $this->generateContent($prompt, [
            'type' => 'seo',
            'max_tokens' => 200,
        ]);
    }

    /**
     * Generate page content
     */
    public function generatePageContent(array $params): array
    {
        $prompt = "Create content for a {$params['page_type']} page";
        
        if (isset($params['company_name'])) {
            $prompt .= " for {$params['company_name']}";
        }
        
        if (isset($params['industry'])) {
            $prompt .= " in the {$params['industry']} industry";
        }
        
        if (isset($params['key_points'])) {
            $prompt .= ". Include these key points: " . implode(', ', $params['key_points']);
        }

        return $this->generateContent($prompt, [
            'type' => 'page_content',
            'max_tokens' => 1500,
        ]);
    }

    /**
     * Generate AI chatbot response
     */
    public function generateChatbotResponse(string $question, array $context = []): array
    {
        $contextPrompt = '';
        if (!empty($context)) {
            $contextPrompt = "Context: " . implode(' ', $context);
        }

        $prompt = "You are a helpful assistant for an admin panel. 
                  {$contextPrompt}
                  
                  Question: {$question}
                  
                  Provide a helpful, concise answer. If you don't know something, say so politely.";

        return $this->generateContent($prompt, [
            'type' => 'chatbot',
            'max_tokens' => 500,
        ]);
    }

    /**
     * Generate content variations
     */
    public function generateContentVariations(string $originalContent, int $count = 3): array
    {
        $prompt = "Create {$count} different variations of this content while maintaining the same meaning and key information:
                  
                  Original: {$originalContent}
                  
                  Return each variation on a new line starting with 'Variation 1:', 'Variation 2:', etc.";

        $result = $this->generateContent($prompt, [
            'type' => 'variations',
            'max_tokens' => 1000,
        ]);

        if ($result['success']) {
            $variations = [];
            $lines = explode("\n", $result['content']);
            
            foreach ($lines as $line) {
                if (preg_match('/Variation \d+:(.+)/', $line, $matches)) {
                    $variations[] = trim($matches[1]);
                }
            }
            
            $result['variations'] = $variations;
        }

        return $result;
    }

    /**
     * Get system prompt based on content type
     */
    protected function getSystemPrompt(string $type): string
    {
        $prompts = [
            'blog_post' => 'You are a professional content writer. Create engaging, informative blog posts with proper structure, headings, and actionable insights.',
            'seo' => 'You are an SEO expert. Create compelling meta descriptions that improve click-through rates and include relevant keywords naturally.',
            'page_content' => 'You are a professional copywriter. Create clear, persuasive page content that engages visitors and drives action.',
            'chatbot' => 'You are a helpful assistant for an admin panel. Provide clear, concise answers to user questions about the system.',
            'variations' => 'You are a creative writer. Create different versions of content while maintaining the core message and information.',
            'general' => 'You are a helpful AI assistant. Provide accurate, well-structured responses to user requests.',
        ];

        return $prompts[$type] ?? $prompts['general'];
    }

    /**
     * Check if AI service is available
     */
    public function isAvailable(): bool
    {
        return !empty($this->apiKey) && config('ai.enabled', true);
    }

    /**
     * Get supported models
     */
    public function getSupportedModels(): array
    {
        return [
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo (Fast, Cost-effective)',
            'gpt-4' => 'GPT-4 (High Quality, More Expensive)',
            'gpt-4-turbo' => 'GPT-4 Turbo (Latest, Best Quality)',
        ];
    }

    /**
     * Clear AI cache
     */
    public function clearCache(): bool
    {
        try {
            Cache::tags(['ai_generated'])->flush();
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to clear AI cache: ' . $e->getMessage());
            return false;
        }
    }
}