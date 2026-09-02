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
            $rootUser = User::where('role_id', 1)->first() ?? User::first();
        }

        $treeData = $this->buildBinaryTreeData($rootUser);

        return view('admin.network.tree', compact('rootUser', 'treeData'));
    }

    /**
     * Build 3-level binary tree structure for visual display.
     */
    private function buildBinaryTreeData(User $root): array
    {
        $left1 = $root->leftChild();
        $right1 = $root->rightChild();

        $left_left2 = $left1 ? $left1->leftChild() : null;
        $left_right2 = $left1 ? $left1->rightChild() : null;

        $right_left2 = $right1 ? $right1->leftChild() : null;
        $right_right2 = $right1 ? $right1->rightChild() : null;

        return [
            'root' => $root,
            'left1' => $left1,
            'right1' => $right1,
            'left_left2' => $left_left2,
            'left_right2' => $left_right2,
            'right_left2' => $right_left2,
            'right_right2' => $right_right2,
        ];
    }
}
