<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert(
            [
                ['name' => 'Solicitado','created_at'=> Carbon::now()],
                ['name' => 'Aprovado','created_at'=> Carbon::now()],
                ['name' => 'Cancelado','created_at'=> Carbon::now()],
            ]
        );
    }
}
