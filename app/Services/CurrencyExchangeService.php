<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyExchangeService
{
    private const CACHE_KEY = 'exchange_rate_usd_to_cop';

    private const CACHE_TTL = 86400; // 24 hours in seconds

    private string $apiKey;

    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.exchangerate.api_key');
        $this->apiUrl = config('services.exchangerate.url');
    }

    /**
     * Get the USD to COP exchange rate (cached for 24 hours)
     */
    public function getUsdToCopRate(): int
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return $this->fetchUsdToCopRate();
        });
    }

    /**
     * Fetch the USD to COP rate from the API
     */
    private function fetchUsdToCopRate(): int
    {
        try {
            $response = Http::get("{$this->apiUrl}/{$this->apiKey}/latest/USD");

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['conversion_rates']['COP'])) {
                    return (int) round($data['conversion_rates']['COP']);
                }
            }

            // Fallback rate if API fails (approximate rate)
            return 4000;
        } catch (\Exception $e) {
            Log::error('Exchange rate API error: '.$e->getMessage());

            return 4000;
        }
    }
}
