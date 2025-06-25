<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Mercedes-Benz',
                'model' => 'S-Class',
                'year' => 2023,
                'price' => 2500000000,
                'color' => 'Obsidian Black',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 5000,
                'description' => 'Luxury sedan dengan teknologi terdepan, interior mewah dengan leather premium, sistem audio Burmester, dan fitur keselamatan canggih.',
                'status' => 'available',
                'featured' => true,
            ],
            [
                'brand' => 'BMW',
                'model' => '7 Series',
                'year' => 2023,
                'price' => 2300000000,
                'color' => 'Alpine White',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 8000,
                'description' => 'Executive sedan dengan desain elegan, teknologi iDrive terbaru, dan performa mesin yang powerful.',
                'status' => 'available',
                'featured' => true,
            ],
            [
                'brand' => 'Audi',
                'model' => 'A8',
                'year' => 2022,
                'price' => 2100000000,
                'color' => 'Daytona Gray',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 12000,
                'description' => 'Flagship sedan dengan quattro all-wheel drive, interior minimalist yang mewah, dan teknologi autonomous driving.',
                'status' => 'available',
                'featured' => false
            ],
            [
                'brand' => 'Porsche',
                'model' => '911 Carrera',
                'year' => 2023,
                'price' => 3500000000,
                'color' => 'GT Silver Metallic',
                'transmission' => 'Manual',
                'fuel_type' => 'Petrol',
                'mileage' => 3000,
                'description' => 'Sports car legendaris dengan performa luar biasa, handling presisi, dan desain ikonik yang timeless.',
                'status' => 'available',
                'featured' => true,
            ],
            [
                'brand' => 'Ferrari',
                'model' => 'F8 Tributo',
                'year' => 2022,
                'price' => 8500000000,
                'color' => 'Rosso Corsa',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 5000,
                'description' => 'Supercar Italia dengan mesin V8 twin-turbo, aerodinamika canggih, dan performa track yang exceptional.',
                'status' => 'sold',
                'featured' => false,
            ],
            [
                'brand' => 'Lamborghini',
                'model' => 'Huracán',
                'year' => 2023,
                'price' => 7500000000,
                'color' => 'Verde Mantis',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 2000,
                'description' => 'Supercar dengan desain agresif, mesin V10 naturally aspirated, dan karakter yang wild dan eksotis.',
                'status' => 'reserved',
                'featured' => true,
            ],
            [
                'brand' => 'Bentley',
                'model' => 'Continental GT',
                'year' => 2023,
                'price' => 4500000000,
                'color' => 'British Racing Green',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 7000,
                'description' => 'Grand tourer mewah dengan craftsmanship Inggris, interior handcrafted, dan performa yang refined.',
                'status' => 'available',
                'featured' => false,
            ],
            [
                'brand' => 'Rolls-Royce',
                'model' => 'Phantom',
                'year' => 2022,
                'price' => 15000000000,
                'color' => 'Arctic White',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 15000,
                'description' => 'Ultimate luxury sedan dengan starlight headliner, suicide doors, dan level kemewahan tertinggi.',
                'status' => 'available',
                'featured' => true,
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2021,
                'price' => 350000000,
                'color' => 'Silver',
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'mileage' => 15000,
                'description' => 'Sedan nyaman dengan teknologi hybrid yang hemat bahan bakar.',
                'status' => 'available',
                'featured' => false,
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2020,
                'price' => 300000000,
                'color' => 'Black',
                'transmission' => 'Manual',
                'fuel_type' => 'Petrol',
                'mileage' => 20000,
                'description' => 'Sedan sporty dengan desain modern dan performa yang handal.',
                'status' => 'available',
                'featured' => true,
            ],
            [
                'brand' => 'Ford',
                'model' => 'Mustang',
                'year' => 2022,
                'price' => 800000000,
                'color' => 'Red',
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'mileage' => 5000,
                'description' => 'Mobil sport legendaris dengan performa tinggi dan desain ikonik.',
                'status' => 'available',
                'featured' => true,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}