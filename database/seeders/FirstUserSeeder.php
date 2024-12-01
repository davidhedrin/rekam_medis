<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tableName = (new User)->getTable();
        if (Schema::hasTable($tableName)) {
            $rowCount = User::count();
            if ($rowCount > 0) {
                User::truncate();
            }
            DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $passHash = Hash::make('rkms2024');
        User::create([
            'username' => 'rkms2024',
            'password' => $passHash,
            'fullname' => 'IR. Totok Andi Prasetyo MT, TN',
            'role_id' => 1,
            'email' => 'rekammedismandiri@gmail.com',
            'email_verified_at' => now(),
            'created_by' => 'SEEDER',
            'created_at' => now(),
            'created_by' => 'Seeder'
        ]);
    }
}
