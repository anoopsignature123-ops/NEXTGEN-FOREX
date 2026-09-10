<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class GatewaySettingService
{
    protected string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/gateway_settings.json');
    }

    /**
     * Get all Gateway Settings (API Key & Mode)
     */
    public function getSettings(): array
    {
        if (File::exists($this->filePath)) {
            $data = json_decode(File::get($this->filePath), true);
            if (is_array($data)) {
                return [
                    'api_key' => $data['api_key'] ?? env('PAYMENT_GATEWAY_API_KEY', 'pk_Hwho4MCbvOT8j1e6h254lJOkh647N3Zs'),
                    'mode' => $data['mode'] ?? env('PAYMENT_GATEWAY_MODE', 'live'),
                ];
            }
        }

        return [
            'api_key' => env('PAYMENT_GATEWAY_API_KEY', 'pk_Hwho4MCbvOT8j1e6h254lJOkh647N3Zs'),
            'mode' => env('PAYMENT_GATEWAY_MODE', 'live'),
        ];
    }

    /**
     * Save Gateway Settings
     */
    public function saveSettings(string $apiKey, string $mode): void
    {
        $data = [
            'api_key' => trim($apiKey),
            'mode' => in_array($mode, ['live', 'testing', 'test']) ? $mode : 'live',
            'updated_at' => now()->toDateTimeString(),
        ];

        File::ensureDirectoryExists(dirname($this->filePath));
        File::put($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Check if currently in testing mode
     */
    public function isTesting(): bool
    {
        $settings = $this->getSettings();

        return in_array(strtolower($settings['mode']), ['testing', 'test', 'sandbox']);
    }

    /**
     * Get API key
     */
    public function getApiKey(): string
    {
        return $this->getSettings()['api_key'];
    }
}
