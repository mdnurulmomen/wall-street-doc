<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use App\Providers\RouteServiceProvider;

class UserServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_be_retreived_using_service_class(): void
    {
        $user = User::factory()->isAdmin()->create();

        $userService = new UserService($user);

        $users = $userService->index();

        $this->assertNotEmpty($users);
    }

    public function test_trashed_users_can_be_retreived_using_service_class(): void
    {
        $user = User::factory()->isAdmin()->create();

        User::onlyTrashed()->forceDelete();

        User::factory()->create()->delete();

        $userService = new UserService($user);

        $trashedUsers = $userService->trashed();

        $this->assertNotEmpty($trashedUsers);
    }

    public function test_new_users_can_be_created_using_service_class(): void
    {
        $user = User::factory()->isAdmin()->create();

        $userService = new UserService($user);

        $userData = [
            'username' => 'User-Username',
            'email' => 'test-1@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $createdUser = $userService->store($userData);

        $response = $this->post('/login', [
            'email' => $createdUser->email,
            'password' => $userData['password']
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_new_users_can_be_updated_using_service_class(): void
    {
        $user = User::factory()->isAdmin()->create();

        $userService = new UserService($user);

        $userData = [
            'username' => 'user-username-updated',
            'email' => 'test-updated@example.com',
        ];

        $userService->update($userData, $user);

        $user->refresh();

        $this->assertSame('user-username-updated', $user->username);
        $this->assertSame('test-updated@example.com', $user->email);
    }

    public function test_new_users_can_be_soft_deleted_using_service_class(): void
    {
        $users = User::factory()->isAdmin()->count(2)->create();

        $userService = new UserService($users[0]);

        $userService->destroy($users[1]);

        $this->assertSoftDeleted('users', [
            '_id' => $users[1]->id,
            'email' => $users[1]->email,
        ]);

        $users[1]->refresh();

        // Assert the user has been soft-deleted
        $this->assertNotNull($users[1]->deleted_at);
    }
}
