<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Lucas Passos Silva dos Santos',
            'email' => 'lucas.p@bcode.com.br',
            'email_verified_at' => now(),
            'password' => '$2y$10$rxOZ9Qvu4ab9uPwcnireBOewMp4yPRSKg4oVmFFl1PVNP1qpcnDSO',
            'remember_token' => 'bhgAe2hvFrM4J5WxSBDvEELAZpPKUgiEYcd6PJHLgHjHUVWoxP9Zobs4TCNQ',
        ]);

        User::create([
            'name' => 'Claudio Tomaz',
            'email' => 'tomaz.claudio@bol.com.br',
            'email_verified_at' => now(),
            'password' => '$2y$10$v63Nn8wY8rRgo/nzCL48b.juAy14Cs3PUcrDjtM7Lj82gHdb9GifW',
            'remember_token' => 'KFMEJNp4kwZ2LBASXUHU4uvK9Q3XrCpZD83g9q0OZKOukHNxFoYe3HhKI6hY',
        ]);
    }
}
