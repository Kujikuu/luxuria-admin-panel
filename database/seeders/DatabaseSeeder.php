<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\Listing;
use App\Models\User;
use Database\Factories\BrokerFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Broker::factory(5)->create();
        Listing::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'a@a.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
