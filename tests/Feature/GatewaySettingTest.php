<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\GatewaySettingService;
use App\Services\PaymentGatewayService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GatewaySettingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_access_gateway_settings_page(): void
    {
        $admin = User::factory()->create([
            'role_id' => 1,
        ]);

        $response = $this->actingAs($admin)->get('/admin/gateway-settings');

        $response->assertStatus(200);
        $response->assertSee('PAYMENT GATEWAY CONFIGURATION');
        $response->assertSee('GATEWAY API & MODE SETTINGS', false);
    }

    public function test_admin_can_update_gateway_mode_to_testing_and_live(): void
    {
        $admin = User::factory()->create([
            'role_id' => 1,
        ]);

        $response = $this->actingAs($admin)->put('/admin/gateway-settings', [
            'api_key' => 'pk_test_123456789',
            'mode' => 'testing',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $settingService = app(GatewaySettingService::class);
        $this->assertTrue($settingService->isTesting());
        $this->assertEquals('pk_test_123456789', $settingService->getApiKey());
    }

    public function test_payment_gateway_in_testing_mode_does_not_call_external_api_and_simulates_success(): void
    {
        $settingService = app(GatewaySettingService::class);
        $settingService->saveSettings('pk_test_key', 'testing');

        $gatewayService = app(PaymentGatewayService::class);

        $paymentResult = $gatewayService->createPayment('DEPTEST123', 100.00);
        $this->assertTrue($paymentResult['success']);
        $this->assertEquals('testing', $paymentResult['mode']);
        $this->assertNotNull($paymentResult['data']['paymentAddress']);

        $statusResult = $gatewayService->checkPaymentStatus('DEPTEST123');
        $this->assertTrue($statusResult['success']);
        $this->assertTrue($statusResult['payment_confirmed']);
    }
}
