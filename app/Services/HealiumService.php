<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HealiumService
{
    private const API_BASE_URL = 'http://healium.giize.com/api';

    private const TIMEOUT_SECONDS = 10;

    public function getSuppliers(): array
    {
        try {
            $response = Http::timeout(self::TIMEOUT_SECONDS)
                ->get(self::API_BASE_URL.'/supplier');

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            Log::warning('Healium API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Error fetching Healium suppliers: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return [];
        }
    }
}
