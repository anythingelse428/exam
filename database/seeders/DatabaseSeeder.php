<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('table')->insert(
            [
                'places'=>6,
                'number'=>1,
                'price'=>100,
            ],
        );
        DB::table('table')->insert(
            [
                'places'=>8,
                'number'=>2,
                'price'=>100,
            ],
        );
        DB::table('table')->insert(
            [
                'places'=>6,
                'number'=>3,
                'price'=>100,
            ],
        );
        DB::table('order')->insert(
            [
                'reserve_start'=>Carbon::now(),
                'reserve_end'=>Carbon::now()->addMinutes(3),
                'places'=>3,
                'table_number'=>1,
                'phone'=>'+799999999',
                'wish'=>'wish',
                'name'=>'Foo',
            ],
        );
        DB::table('order')->insert(
            [
                'reserve_start'=>Carbon::now(),
                'reserve_end'=>Carbon::now()->addMinutes(3),
                'places'=>3,
                'table_number'=>2,
                'phone'=>'+799999999',
                'wish'=>'wish',
                'name'=>'Foo',
            ],
        );
        DB::table('order')->insert(
            [
                'reserve_start'=>Carbon::now(),
                'reserve_end'=>Carbon::now()->addMinutes(3),
                'places'=>1,
                'table_number'=>3,
                'phone'=>'+799999999',
                'wish'=>'wish',
                'name'=>'Foo',
            ],
        );
    }
}
