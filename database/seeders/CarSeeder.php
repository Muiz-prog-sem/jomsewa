<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $car_seed = [
            ['id'=>'1', 
             'model'=>'Toyota Alphard',
             'type'=>'MPV', 
             'color'=>'White',
             'person'=>'8',
             'available'=>'4',
             'price'=>'120',
             'image'=>'uploads/alphardputih.png'],

             ['id'=>'2', 
             'model'=>'Perodua Axia',
             'type'=>'Hatchback', 
             'color'=>'Red',
             'person'=>'5',
             'available'=>'6',
             'price'=>'70',
             'image'=>'uploads/axiamerah.png'],

             ['id'=>'3', 
             'model'=>'Perodua Bezza 1.3X',
             'type'=>'Sedan', 
             'color'=>'Blue',
             'person'=>'5',
             'available'=>'3',
             'price'=>'94',
             'image'=>'uploads/bezzabiru.png'],

             ['id'=>'4', 
             'model'=>'Perodua Bezza 1.3Adv',
             'type'=>'Sedan', 
             'color'=>'Red',
             'person'=>'5',
             'available'=>'5',
             'price'=>'89',
             'image'=>'uploads/bezzamerah.png'],

             ['id'=>'5', 
             'model'=>'Honda City 1.3',
             'type'=>'Sedan', 
             'color'=>'Red',
             'person'=>'5',
             'available'=>'4',
             'price'=>'87',
             'image'=>'uploads/hondacitymerah.png'],

             ['id'=>'6', 
             'model'=>'Toyota Corolla',
             'type'=>'SUV', 
             'color'=>'Red',
             'person'=>'5',
             'available'=>'8',
             'price'=>'102',
             'image'=>'uploads/toyotacorollamerah.png'],
        ];

        foreach ($car_seed as $car_seed)
        {
            Car::firstOrCreate($car_seed);
        }
    }
}
