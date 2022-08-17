<?php

namespace Tests;

use A17\Twill\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser($params = [])
    {
        $faker = app(Faker::class);

        $user = User::create(
            array_merge(
                [
                    'role' => 'ADMIN',
                    'published' => 1,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('secret'),
                ],
                $params
            )
        );

        return $user;
    }

    public function loginAs($user)
    {
        return $this->actingAs($user, 'twill_users');
    }

    public function asAdmin()
    {
        $user = $this->createUser(
            [
                'email' => 'admin@test.test',
                'role' => 'ADMIN',
            ]
        );

        $this->loginAs($user);

        return $user;
    }

    public function asSuperAdmin()
    {
        $user = $this->createUser(
            [
                'email' => 'superadmin@test.test',
                'role' => 'SUPERADMIN',
            ]
        );

        $this->loginAs($user);

        return $user;
    }

    public function asPublisher()
    {
        $user = $this->createUser(
            [
                'email' => 'publisher@test.test',
                'role' => 'PUBLISHER',
            ]
        );

        $this->loginAs($user);

        return $user;
    }
}
