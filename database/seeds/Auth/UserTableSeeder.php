<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'PASS@word1234',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'api_token' => Str::random(64),
        ]);

        User::create([
            'first_name' => 'Default',
            'last_name' => 'User',
            'email' => 'user@user.com',
            'password' => 'PASS@word1234',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'api_token' => Str::random(64),
        ]);

        $this->enableForeignKeys();
    }
}
