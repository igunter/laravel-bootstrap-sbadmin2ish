<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'is_admin'   => true,
            'name'       => 'Test User',
            'email'      => 'test@example.com',
            'password'   => bcrypt('P4$$w0rd!'),
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(7),
        ]);

        User::factory(rand(20,500))->create();
    }
}
