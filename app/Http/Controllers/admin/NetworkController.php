<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NetworkController extends Controller
{
    /**
     * Display listing of direct members across network in Admin Panel.
     */
    public function directMembers(Request $request): View
    {
        $query = User::with(['sponsor'])->whereNotNull('sponsor_code');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('referral_code', 'like', "%{$search}%")
                    ->orWhere('sponsor_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $directs = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => User::whereNotNull('sponsor_code')->count(),
            'active' => User::whereNotNull('sponsor_code')->where('status', 'active')->count(),
            'left' => User::whereNotNull('sponsor_code')->where('position', 'left')->count(),
            'right' => User::whereNotNull('sponsor_code')->where('position', 'right')->count(),
        ];

        return view('admin.network.direct', compact('directs', 'stats'));
    }

    /**
     * Display Visual Binary Team Tree in Admin Panel.
     */
    public function treeView(Request $request): View
    {
        $searchCode = $request->query('code');

        if ($searchCode) {
            $rootUser = User::where('referral_code', $searchCode)->first();
        }

        if (! isset($rootUser) || ! $rootUser) {
            $rootUser = User::where('role_id', 2)->whereNull('sponsor_code')->first() ?? User::where('role_id', 2)->first();
        }

        $treeData = $this->buildBinaryTreeData($rootUser);
        $directMembers = User::where('sponsor_code', $rootUser->referral_code)->latest()->get();

        return view('admin.network.tree', compact('rootUser', 'treeData', 'directMembers'));
    }

    /**
     * Build dynamic genealogy team tree structure for visual display.
     */
    private function buildBinaryTreeData(User $root): array
    {
        $root->load(['sponsor', 'userPackages', 'transactions']);

        // Load all direct referrals of root with sponsor, packages, transactions & count
        $directMembers = User::where('sponsor_code', $root->referral_code)
            ->with(['sponsor', 'userPackages', 'transactions'])
            ->withCount('directMembers')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($directMembers as $direct) {
            $direct->sub_children = User::where('sponsor_code', $direct->referral_code)
                ->with(['sponsor', 'userPackages', 'transactions'])
                ->withCount('directMembers')
                ->orderBy('id', 'asc')
                ->get();
        }

        return [
            'root' => $root,
            'directs' => $directMembers,
            'total_directs' => $directMembers->count(),
            'active_directs' => $directMembers->where('status', 'active')->count(),
        ];
    }
}
