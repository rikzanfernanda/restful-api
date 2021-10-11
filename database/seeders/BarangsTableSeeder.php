<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Barang 1'
            ],
            [
                'name' => 'Barang 2'
            ],
            [
                'name' => 'Barang 3'
            ],
            [
                'name' => 'Barang 4'
            ],
            [
                'name' => 'Barang 5'
            ],
        ];

        foreach ($data as $dt) {
//            Barang::create([
//                'name' => $dt['name']
//            ]);
            $barang = new Barang();
            $barang->name = $dt['name'];
            $barang->save();
        }
    }
}
