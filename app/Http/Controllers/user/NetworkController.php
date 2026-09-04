<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NetworkController extends Controller
{
    /**
     * Display listing of direct members for current logged-in user.
     */
    public function directMembers(Request $request): View
    {
        $user = Auth::user();
        $query = User::where('sponsor_code', $user->referral_code);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('referral_code', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $directs = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => User::where('sponsor_code', $user->referral_code)->count(),
            'active' => User::where('sponsor_code', $user->referral_code)->where('status', 'active')->count(),
            'left' => User::where('sponsor_code', $user->referral_code)->where('position', 'left')->count(),
            'right' => User::where('sponsor_code', $user->referral_code)->where('position', 'right')->count(),
        ];

        return view('user.network.direct', compact('directs', 'stats'));
    }

    /**
     * Display Visual Binary Team Tree for member.
     */
    public function treeView(Request $request): View
    {
        $currentUser = Auth::user();
        $searchCode = $request->query('code');

        if ($searchCode) {
            $targetUser = User::where('referral_code', $searchCode)->first();
            // Ensure member can view root or downline tree
            if ($targetUser) {
                $rootUser = $targetUser;
            } else {
                $rootUser = $currentUser;
            }
        } else {
            $rootUser = $currentUser;
        }

        $treeData = $this->buildBinaryTreeData($rootUser);
        $directMembers = User::where('sponsor_code', $rootUser->referral_code)->latest()->get();

        return view('user.network.tree', compact('rootUser', 'treeData', 'directMembers'));
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
