<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
        ]);

        Category::factory(7)->create();

        Item::factory(10)->create([
            'user_id' => 1
        ]);

        Item::factory(10)->create([
            'user_id' => 2
        ]);

        Address::factory(20)->create();
    }
}
