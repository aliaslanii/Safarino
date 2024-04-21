<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Airlines;
use App\Models\Airport;
use App\Models\City;
use App\Models\Passenger;
use App\Models\Railcompanie;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Ali Aslani',
            'mobile' => '09227659746',
            'email' => 'a@a.com',
            'password' => Hash::make('Ali_1727'),
        ]);
        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->inventory = 0;
        $wallet->status = true;
        $wallet->save();
        City::factory(30)->create();
        Airlines::factory(30)->create();
        Airport::factory(30)->create();
        Railcompanie::factory(30)->create();
        Passenger::factory(30)->create();
        Role::create([
            'name' => 'Admin'
        ]);
        Role::create([
            'name' => 'Read'
        ]);
        Role::create([
            'name' => 'Create'
        ]);
        Role::create([
            'name' => 'Update'
        ]);
        Role::create([
            'name' => 'Delete'
        ]);
        RoleUser::create([
            'role_id' => 1,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 2,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 3,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 4,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 5,
            'user_id' => 1
        ]);
    }
}
