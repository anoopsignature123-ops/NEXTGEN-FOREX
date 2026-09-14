<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserEditTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_view_edit_user_page(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $member = User::factory()->create(['role_id' => 2, 'referral_code' => 'NGF-TESTMEMBER']);

        $response = $this->actingAs($admin)
            ->withSession(['admin_user_id' => $admin->id])
            ->get(route('admin.users.edit', $member->id));

        $response->assertStatus(200);
        $response->assertSee('EDIT MEMBER: NGF-TESTMEMBER');
    }

    public function test_admin_can_update_user_profile_details(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $member = User::factory()->create([
            'role_id' => 2,
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'mobile' => '1234567890',
            'sponsor_code' => null,
            'position' => 'left',
            'status' => 'active',
            'is_bot_active' => true,
        ]);

        $response = $this->actingAs($admin)
            ->withSession(['admin_user_id' => $admin->id])
            ->put(route('admin.users.update', $member->id), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'mobile' => '9876543210',
                'sponsor_code' => '',
                'status' => 'inactive',
                'is_bot_active' => '0',
            ]);

        $response->assertRedirect(route('admin.users'));
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertEquals('Updated Name', $member->name);
        $this->assertEquals('updated@example.com', $member->email);
        $this->assertEquals('9876543210', $member->mobile);
        $this->assertEquals('inactive', $member->status);
        $this->assertFalse((bool) $member->is_bot_active);
    }
}
