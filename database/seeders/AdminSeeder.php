<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'username'=> 'Admin',
            'email' => 'jhlargo@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Hafa1993'),
            'admin' => 1,
            'approved_at' => now(),
        ]);
    }
}
