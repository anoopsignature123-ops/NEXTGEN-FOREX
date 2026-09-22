<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserLoginRestrictionTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_credentials_cannot_login_via_user_login_form(): void
    {
        $admin = User::factory()->create([
            'role_id' => 1,
            'email' => 'admin_restricted_test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('user.login'), [
            'email' => 'admin_restricted_test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_normal_member_can_login_via_user_login_form(): void
    {
        $member = User::factory()->create([
            'role_id' => 2,
            'email' => 'member_login_test@example.com',
            'password' => bcrypt('password123'),
            'status' => 'active',
        ]);

        $response = $this->post(route('user.login'), [
            'email' => 'member_login_test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($member);
    }

    public function test_admin_accessing_user_routes_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($admin)->get(route('user.dashboard'));

        $response->assertRedirect(route('admin.dashboard'));
    }
}
