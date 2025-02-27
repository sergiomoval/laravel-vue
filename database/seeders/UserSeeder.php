<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Sergio Moreno';
        $user->email = 'sergiomorenoval@gmail.com';
        $user->password = Hash::make('sergio90');
        $user->email_verified_at = Carbon::now();
        $user->assignRole('Administrator');
        $user->save();
    }
}
