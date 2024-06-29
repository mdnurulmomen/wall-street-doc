<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Pagination\Paginator;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_be_retreived_at_controller_index_method(): void
    {
        $user = User::factory()->isAdmin()->create();

        $response = $this
            ->actingAs($user)
            ->get('/users');

        $this->assertNotEmpty($response);

        // $this->assertInstanceOf(Paginator::class, $response->viewData('users'));
    }

    public function test_trashed_users_can_be_retreived_at_controller_trashed_method(): void
    {
        $user = User::factory()->isAdmin()->create();

        User::onlyTrashed()->forceDelete();

        User::factory()->create()->delete();

        $response = $this
            ->actingAs($user)
            ->get(route('users.trashed'));

        $this->assertNotEmpty($response);
    }

    public function test_new_users_can_be_created_using_controller_store_method(): void
    {
        $admin = User::factory()->isAdmin()->create();

        $userData = [
            'username' => 'test-one',
            'email' => 'test-one@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->actingAs($admin)
        ->post(route('users.store'), $userData);

        $response = $this->post('/login', [
            'email' => $userData['email'],
            'password' => $userData['password']
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_new_users_can_be_updated_using_controller_update_method(): void
    {
        $admin = User::factory()->isAdmin()->create();

        $user = User::factory()->create();

        $userData = [
            'username' => 'updated-username',
            'email' => 'updated@example.com',
        ];

        $this->actingAs($admin)
        ->put(route('users.update', $user->id), $userData);

        $user->refresh();

        $this->assertSame('updated-username', $user->username);
        $this->assertSame('updated@example.com', $user->email);
    }

    public function test_new_users_can_be_soft_deleted_using_controller_destroy_method(): void
    {
        $users = User::factory()->isAdmin()->count(2)->create();

        $this->actingAs($users[0])
        ->delete(route('users.destroy', $users[1]->id));

        $this->assertSoftDeleted('users', [
            '_id' => $users[1]->id,
            'email' => $users[1]->email,
        ]);

        $users[1]->refresh();

        // Assert the user has been soft-deleted
        $this->assertNotNull($users[1]->deleted_at);
    }
}
