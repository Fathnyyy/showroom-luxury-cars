<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $reservedCars = Car::where('status', 'reserved')->count();
        $soldCars = Car::where('status', 'sold')->count();
        $recentCars = Car::latest()->take(6)->get();

        // Contoh data aktivitas (ganti dengan model Activity jika ada)
        $recentActivities = collect([
            (object)[
                'created_at' => now()->subMinutes(10),
                'user' => (object)['name' => 'Admin'],
                'description' => 'Added new car: BMW X5'
            ],
            (object)[
                'created_at' => now()->subHour(),
                'user' => (object)['name' => 'Admin'],
                'description' => 'Sold car: Mercedes S-Class'
            ]
        ]);

        // Contoh data penjualan bulanan
        $salesMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $salesData = [2, 4, 3, 5, 1, 6];

        return view('dashboard', compact(
            'totalCars', 'availableCars', 'reservedCars', 'soldCars',
            'recentCars', 'recentActivities', 'salesMonths', 'salesData'
        ));
    }
}
