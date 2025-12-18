<?php

namespace App\Infrastructure\ExternalApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OldErpApiClient
{
    private string $baseUrl;
    private ?string $syncToken;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.old_erp.url', 'https://erp.sk-gorod.com'), '/');
        $this->syncToken = config('services.old_erp.sync_token');
        $this->timeout = config('services.old_erp.timeout', 30);
    }

    public function getUsers(): array
    {
        return $this->fetchData('/api/users-sync');
    }

    private function fetchData(string $endpoint): array
    {
        try {
            $http = Http::timeout($this->timeout)
                ->withHeaders($this->getAuthHeaders());

            $verifySSL = config('services.old_erp.verify_ssl', true);
            if (app()->environment('local') || $verifySSL === false) {
                $http = $http->withoutVerifying();
            }

            $response = $http->get($this->baseUrl . $endpoint);

            if (!$response->successful()) {
                throw new Exception(
                    "Failed to fetch data from OLD ERP ({$endpoint}): HTTP {$response->status()}"
                );
            }

            $responseData = $response->json();

            if (isset($responseData['data']) && is_array($responseData['data'])) {
                $data = $responseData['data'];
            } elseif (is_array($responseData)) {
                $data = $responseData;
            } else {
                throw new Exception("Invalid response format from OLD ERP ({$endpoint})");
            }

            return $data;
        } catch (Exception $e) {
            Log::error("OLD ERP API request failed ({$endpoint}): " . $e->getMessage());
            throw $e;
        }
    }

    private function getAuthHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        if ($this->syncToken) {
            $headers['Authorization'] = 'Bearer ' . $this->syncToken;
            $headers['X-Sync-Token'] = $this->syncToken;
        }

        return $headers;
    }
}

