<?php
use App\Models\User;
use App\Models\Task;

test('Authenticated user can create a task', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('tasks.store'), [
        'title' => 'Test Task',
    ]);

    $response->assertRedirect(route('tasks.index'));
    $this->assertDatabaseHas('tasks', [
        'title' => 'Test Task',
        'user_id' => $user->id,
    ]);
});

test('If task is not yours, you cannot update it', function () {
    $attacker = User::factory()->create();
    $this->actingAs($attacker);

    $task = Task::factory()->create();

    $response = $this->patch(route('tasks.update', $task), [
        'title' => 'Updated Task',
    ]);
    $response->assertStatus(403);
});

test('Guest user can\'t create a task', function () {
    $response = $this->post(route('tasks.store'));
    $response->assertRedirect(route('login'));
});

test('If you are a authenticated user, you can see only your tasks', function () {
    $task = Task::factory()->create();
    $user = $task->user;
    $this->actingAs($user);
    $response = $this->get(route('tasks.show', $task));
    $response->assertStatus(200);
});

test('If task is not yours, you cannot see it', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $task = Task::factory()->create();
    $response = $this->get(route('tasks.show', $task));
    $response->assertStatus(403);
});