<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of all packages.
     */
    public function index(): View
    {
        $packages = Package::withCount('userPackages')->orderBy('id', 'asc')->get();

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show form to create a new package.
     */
    public function create(): View
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created package in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:1',
            'max_amount' => 'required|numeric|gte:min_amount',
            'daily_roi' => 'required|numeric|min:0.01|max:100',
            'duration_days' => 'required|integer|min:1',
            'total_return_multiplier' => 'required|numeric|min:1',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'New package created successfully.');
    }

    /**
     * Show form to edit package.
     */
    public function edit(Package $package): View
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update specified package in database.
     */
    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:1',
            'max_amount' => 'required|numeric|gte:min_amount',
            'daily_roi' => 'required|numeric|min:0.01|max:100',
            'duration_days' => 'required|integer|min:1',
            'total_return_multiplier' => 'required|numeric|min:1',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Quick status toggle for package (active <-> inactive).
     */
    public function toggleStatus(Package $package): RedirectResponse
    {
        $newStatus = $package->status === 'active' ? 'inactive' : 'active';
        $package->update(['status' => $newStatus]);

        return redirect()->back()->with('success', "Package status changed to {$newStatus}.");
    }
}
