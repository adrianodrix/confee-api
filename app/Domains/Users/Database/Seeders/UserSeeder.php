<?php

namespace Confee\Domains\Users\Database\Seeders;

use Confee\Domains\Users\User;
use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 * @package Confee\Domains\Users\Database\Seeders
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)
            ->times(100)
            ->create();
    }
}