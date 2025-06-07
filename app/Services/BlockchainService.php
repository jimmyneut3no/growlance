<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlockchainService
{
    protected $nodeUrl;
    protected $sharedSecret;

    public function __construct()
    {
        $this->nodeUrl = config('services.node.url');
        $this->sharedSecret = config('services.node.shared_secret');
    }

    protected function sendSecureRequest(string $endpoint, array $payload)
    {
        try {
            $timestamp = now()->timestamp;
            $body = json_encode($payload);
            $signature = hash_hmac('sha256', $body . $timestamp, $this->sharedSecret);

            $response = Http::withHeaders([
                'X-Timestamp' => $timestamp,
                'X-Hmac-Signature' => $signature,
                'Accept' => 'application/json',
            ])->post($this->nodeUrl . $endpoint, $payload);

            return $response;
        } catch (\Exception $e) {
            Log::error("Secure request to $endpoint failed", [
                'error' => $e->getMessage(),
                'endpoint' => $endpoint,
                'payload' => $payload,
            ]);
            return null;
        }
    }
    protected function sendSecureGetRequest(string $endpoint)
    {
        try {
            $timestamp = now()->timestamp;
            $signature = hash_hmac('sha256', $timestamp, $this->sharedSecret);

            // $response = Http::withHeaders([
            //     'X-Timestamp' => $timestamp,
            //     'X-Hmac-Signature' => $signature,
            //     'Accept' => 'application/json',
            // ])->get($this->nodeUrl . $endpoint, $payload);

        $headers = [
            'X-Hmac-Signature' => $signature,
            'X-Timestamp' => $timestamp,
            'Accept' => 'application/json',
        ];

        Log::info('Sending secure request', [
            'url' => $this->nodeUrl . $endpoint,
            'headers' => $headers,
        ]);

        $response = Http::withHeaders($headers)->get($this->nodeUrl . $endpoint);

            return $response;
        } catch (\Exception $e) {
            Log::error("Secure request to $endpoint failed", [
                'error' => $e->getMessage(),
                'endpoint' => $endpoint,
            ]);
            return null;
        }
    }
    public function getDepositAddress(User $user)
    {
        $response = $this->sendSecureGetRequest("/generate-address/$user->id");

        if ($response && $response->successful()) {
            return $response->json('address');
        }

        Log::error('Failed to generate deposit address', [
            'user_id' => $user->id,
            'response' => optional($response)->json(),
        ]);

        throw new \Exception('Failed to generate deposit address');
    }

    public function processWithdrawal($payload)
    {
        $response = $this->sendSecureRequest('/withdraw', $payload);

        if ($response && $response->successful()) {
            Log::info("result: BS True");
            return true;
        //  return [
        //         'success' => true,
        //         'hash' => $response->json('hash'),
        //     ];
        }

        Log::error('Failed to process withdrawal', [
            'transaction_id' => $payload['id'],
            'response' => optional($response)->json(),
        ]);

        return [
            'success' => false,
            'message' => optional($response)->json('message', 'Failed to process withdrawal'),
        ];
    }

    public function sweep(User $user)
    {
        $response = $this->sendSecureRequest("/sweep/$user->id", []);

        if ($response && $response->successful()) {

            Log::info('Sweep success', [
            'user_id' => $user->id,
            'response' => optional($response)->json(),
        ]);
        
            return [
                'success' => true,
                'message' => 'Sweep completed',
                'data' => $response->json(),
            ];
        }

        Log::error('Sweep failed', [
            'user_id' => $user->id,
            'response' => optional($response)->json(),
        ]);

        return [
            'success' => false,
            'message' => 'Sweep failed',
        ];
    }

    public function refresh(User $user)
    {
        $payload = ['user_id' => $user->id];

        $response = $this->sendSecureRequest('/refresh', $payload);

        if ($response && $response->successful()) {
            return [
                'success' => true,
                'message' => 'Refresh completed',
                'data' => $response->json(),
            ];
        }

        Log::error('Refresh failed', [
            'user_id' => $user->id,
            'response' => optional($response)->json(),
        ]);

        return [
            'success' => false,
            'message' => 'Refresh failed',
        ];
    }

        public function verifyWebhookSignature(Request $request)
            {
                $signature = $request->header('X-Hmac-Signature');
                $timestamp = $request->header('X-Timestamp');
                $payload = $request->getContent();
                if (!$signature || !$timestamp) {
                    return false;
                }
                $dataToSign = $payload . $timestamp;
                $expectedSignature = hash_hmac('sha256', $dataToSign, $this->sharedSecret);

                return hash_equals($expectedSignature, $signature);
            }

}
