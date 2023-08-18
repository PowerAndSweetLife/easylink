<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private $categories = [
        "Marchandise générales non dangereuse" => 380, 
        "Batteries" => 380, 
        "Equipement lourd" => 380, 
        "téléphone" => 380, 
        "Instrument" => 380
    ];
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('admins')->insert([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@easylink.mg',
            'contact' => '033 00 000 00',
            'is_super_admin' => true
        ]);

        DB::table('metadata')->insert(['key' => 'cbm_min','value' => 150000]);

        DB::table('localizations')->insert(['region' => 'Guangzhou','country' => 'Chine']);
        DB::table('localizations')->insert(['region' => 'Wuhan','country' => 'Chine']);

        DB::table('units')->insert(['name' => 'Dollar americain','alias' => 'USD']);

        foreach($this->categories as $name => $price)
        {
            DB::table('categories')->insert([
                "name" => $name,
                "price" => $price
            ]);
        }
    }
}
