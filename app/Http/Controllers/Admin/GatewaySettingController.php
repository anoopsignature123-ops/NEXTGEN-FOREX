<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GatewaySettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GatewaySettingController extends Controller
{
    /**
     * Display Gateway Credentials & Testing/Live Mode Configuration page.
     */
    public function index(GatewaySettingService $settingService): View
    {
        $settings = $settingService->getSettings();

        return view('admin.gateway_settings', compact('settings'));
    }

    /**
     * Update Payment Gateway Settings.
     */
    public function update(Request $request, GatewaySettingService $settingService): RedirectResponse
    {
        $request->validate([
            'api_key' => ['required', 'string', 'max:255'],
            'mode' => ['required', 'string', 'in:live,testing'],
        ], [
            'api_key.required' => 'Please enter a valid Payment Gateway API Key.',
            'mode.required' => 'Please select a gateway mode (Live or Testing).',
        ]);

        $settingService->saveSettings($request->api_key, $request->mode);

        $modeLabel = $request->mode === 'live' ? 'LIVE Gateway Mode (Real API Requests)' : 'TESTING Mode (Direct Approval Without API Calls)';

        return back()->with('success', "Payment Gateway Settings updated successfully! Active Mode: {$modeLabel}.");
    }
}
