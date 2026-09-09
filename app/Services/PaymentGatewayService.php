<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    private string $ipaymentwalletUrl = 'https://ipaymentwallet.com/api';

    protected GatewaySettingService $settingService;

    public function __construct(GatewaySettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Create payment request for BEP20 USDT deposit
     */
    public function createPayment(string $txnId, float $amount, ?string $redirectUrl = null, ?string $memberId = null): array
    {
        // TESTING MODE: Do not send external API HTTP request, simulate direct deposit session
        if ($this->settingService->isTesting()) {
            $systemWallet = env('USDT_WALLET_ADDRESS', '0x71C7656EC7ab88b098defB751B7401B5f6d8976F');

            return [
                'success' => true,
                'mode' => 'testing',
                'data' => [
                    'paymentAddress' => $systemWallet,
                    'transactionId' => 'TEST_TXN_'.strtoupper(Str::random(10)),
                    'qrUrl' => 'https://quickchart.io/qr?text='.urlencode($systemWallet).'&size=180&margin=1',
                    'redirectUrl' => $redirectUrl ?? config('app.url'),
                    'message' => 'Simulated testing payment session created.',
                ],
            ];
        }

        // LIVE MODE: Send real HTTP request to iPaymentWallet API
        try {
            $apiKey = $this->settingService->getApiKey();

            $payload = [
                'txnId' => $txnId,
                'amount' => (string) $amount,
                'apiKey' => $apiKey,
                'redirectUrl' => $redirectUrl ?? config('app.url'),
            ];

            if ($memberId !== null) {
                $payload['MemberId'] = (string) $memberId;
            }

            $response = Http::timeout(30)->withoutVerifying()->post("{$this->ipaymentwalletUrl}/v1/create-payment", $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            $json = $response->json();
            $errorMessage = $json['message'] ?? $json['error'] ?? $json['msg'] ?? null;
            if (is_array($errorMessage)) {
                $errorMessage = implode(', ', array_map(fn ($val) => is_string($val) ? $val : json_encode($val), $errorMessage));
            }

            return [
                'success' => false,
                'message' => $errorMessage ?: 'Payment gateway initialization failed (HTTP '.$response->status().').',
                'error' => $json,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Payment gateway connection error: '.$e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(string $merchantTxnId): array
    {
        // TESTING MODE: Instantly approve & confirm deposit without calling external API
        if ($this->settingService->isTesting()) {
            return [
                'success' => true,
                'mode' => 'testing',
                'payment_confirmed' => true,
                'data' => [
                    'status' => 'approved',
                    'transaction_hash' => '0x_simulated_bep20_hash_'.strtolower(Str::random(32)),
                    'message' => 'Simulated test deposit auto-approved.',
                ],
            ];
        }

        // LIVE MODE: Check live payment status via HTTP API
        try {
            $apiKey = $this->settingService->getApiKey();

            $response = Http::timeout(30)->withoutVerifying()->withHeaders([
                'X-API-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->ipaymentwalletUrl}/payment/check-status", [
                'transaction_id' => $merchantTxnId,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'success' => true,
                    'data' => $data['data'] ?? $data,
                    'payment_confirmed' => $data['payment_confirmed'] ?? false,
                ];
            }

            $json = $response->json();
            $errorMessage = $json['message'] ?? $json['error'] ?? $json['msg'] ?? null;
            if (is_array($errorMessage)) {
                $errorMessage = implode(', ', array_map(fn ($val) => is_string($val) ? $val : json_encode($val), $errorMessage));
            }

            return [
                'success' => false,
                'message' => $errorMessage ?: 'Status check failed (HTTP '.$response->status().').',
                'status_code' => $response->status(),
                'response' => $json,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Status check connection error: '.$e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }
}
