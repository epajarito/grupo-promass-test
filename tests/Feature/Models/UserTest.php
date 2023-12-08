<?php


use App\Models\User;

it('have active method', function () {
    User::factory()->count(3)->withUserRole()->create();

    expect(User::latest()->get())->toHaveCount(3);
});
