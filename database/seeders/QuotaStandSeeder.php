<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotaStandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_quota_stand')->insert([
            [
                'kd_stand' => 'FT',
                'nama_stand' => 'Stand Foto',
                'quota' =>50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_stand' => 'LK',
                'nama_stand' => 'Stand Lukis',
                'quota' =>30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
