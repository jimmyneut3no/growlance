<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class BlockchainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('blockchain', function ($app) {
            return new class {
                protected $baseUrl;
                protected $apiKey;

                public function __construct()
                {
                    $this->baseUrl = config('services.node.url');
                    $this->apiKey = config('services.node.api_key');
                }

                public function generateAddress(int $userId): string
                {
                    $response = Http::withHeaders([
                        'X-API-Key' => $this->apiKey,
                    ])->post($this->baseUrl . '/generate-address', [
                        'user_id' => $userId,
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Failed to generate address');
                    }

                    return $response->json('address');
                }

                public function processWithdrawal(int $transactionId, int $userId, float $amount, string $address): string
                {
                    $response = Http::withHeaders([
                        'X-API-Key' => $this->apiKey,
                    ])->post($this->baseUrl . '/process-withdrawal', [
                        'transaction_id' => $transactionId,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'address' => $address,
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Failed to process withdrawal');
                    }

                    return $response->json('tx_hash');
                }

                public function verifyTransaction(string $txHash): bool
                {
                    $response = Http::withHeaders([
                        'X-API-Key' => $this->apiKey,
                    ])->get($this->baseUrl . '/verify-transaction', [
                        'tx_hash' => $txHash,
                    ]);

                    return $response->successful() && $response->json('verified');
                }

                public function getBalance(string $address): float
                {
                    $response = Http::withHeaders([
                        'X-API-Key' => $this->apiKey,
                    ])->get($this->baseUrl . '/get-balance', [
                        'address' => $address,
                    ]);

                    if (!$response->successful()) {
                        throw new \Exception('Failed to get balance');
                    }

                    return $response->json('balance');
                }
            };
        });
    }

    public function boot(): void
    {
        //
    }
} 