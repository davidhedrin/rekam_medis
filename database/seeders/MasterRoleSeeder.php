<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tableName = (new MRole)->getTable();
        if (Schema::hasTable($tableName)) {
            $rowCount = MRole::count();
            if ($rowCount > 0) {
                MRole::truncate();
            }
            DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $datas = [
            [
                'slug' => 'dct',
                'name' => 'Dokter',
                'created_by' => 'SEEDER',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'slug' => 'str',
                'name' => 'Suster',
                'created_by' => 'SEEDER',
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        MRole::insert($datas);
    }
}
