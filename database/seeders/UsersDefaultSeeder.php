<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Lucas Passos Silva dos Santos',
            'email' => 'lucas.p@bcode.com.br',
            'email_verified_at' => now(),
            'password' => '$2y$10$rxOZ9Qvu4ab9uPwcnireBOewMp4yPRSKg4oVmFFl1PVNP1qpcnDSO',
            'remember_token' => 'bhgAe2hvFrM4J5WxSBDvEELAZpPKUgiEYcd6PJHLgHjHUVWoxP9Zobs4TCNQ',
        ]);

        $role = Role::create(['name' => 'Desenvolvedor']);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Gustavo Thales Valgoi de Almeida',
            'email' => 'guss.oitenta@gmail.com',
            'email_verified_at' => now(),
            'password' => '$10$A/U9jt3YZC/LpS9AH5.wJ.4rYKK2WQtKWZRU.7YwpkHiTtUCIZAXK', // Hash::make('your_pass')
        ]);

        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Claudio Tomaz',
            'email' => 'tomaz.claudio@bol.com.br',
            'email_verified_at' => now(),
            'password' => '$2y$10$v63Nn8wY8rRgo/nzCL48b.juAy14Cs3PUcrDjtM7Lj82gHdb9GifW',
            'remember_token' => 'KFMEJNp4kwZ2LBASXUHU4uvK9Q3XrCpZD83g9q0OZKOukHNxFoYe3HhKI6hY',
        ]);

        $role = Role::create(['name' => 'Administrador']);

        $permissions = Permission::select('id')->where(DB::raw('REVERSE(name)'), 'NOT LIKE', 'rateled-%')->get();

        $ids = [];
        foreach($permissions as $permission) {
            $ids[] = $permission->id;
        }

        $role->syncPermissions($ids);

        $user->assignRole([$role->id]);
    }
}
