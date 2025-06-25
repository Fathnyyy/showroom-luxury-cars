<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by year range
        if ($request->filled('min_year')) {
            $query->where('year', '>=', $request->min_year);
        }
        if ($request->filled('max_year')) {
            $query->where('year', '<=', $request->max_year);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $cars = $query->paginate(12);

        // Get unique brands for filter
        $brands = Car::distinct()->pluck('brand');

        return view('cars.index', compact('cars', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:255',
            'transmission' => 'required|in:Manual,Automatic',
            'fuel_type' => 'required|string|max:255',
            'mileage' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,sold,reserved',
            'featured' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['image', 'gallery']);
        $data['featured'] = $request->has('featured');

        // Handle main image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $data['image'] = $imagePath;
        }

        // Handle gallery uploads
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPath = $file->store('cars/gallery', 'public');
                $gallery[] = $galleryPath;
            }
            $data['gallery'] = $gallery;
        }

        Car::create($data);

        return redirect()->route('cars.index')
            ->with('success', 'Mobil berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        // Get similar cars (same brand or similar price range)
        $similarCars = Car::where('id', '!=', $car->id)
            ->where(function($query) use ($car) {
                $query->where('brand', $car->brand)
                      ->orWhereBetween('price', [$car->price * 0.7, $car->price * 1.3]);
            })
            ->limit(3)
            ->get();

        return view('cars.show', compact('car', 'similarCars'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:255',
            'transmission' => 'required|in:Manual,Automatic',
            'fuel_type' => 'required|string|max:255',
            'mileage' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,sold,reserved',
            'featured' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['image', 'gallery']);
        $data['featured'] = $request->has('featured');

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $imagePath = $request->file('image')->store('cars', 'public');
            $data['image'] = $imagePath;
        }

        // Handle gallery uploads
        if ($request->hasFile('gallery')) {
            $gallery = $car->gallery ?? [];
            foreach ($request->file('gallery') as $file) {
                $galleryPath = $file->store('cars/gallery', 'public');
                $gallery[] = $galleryPath;
            }
            $data['gallery'] = $gallery;
        }

        $car->update($data);

        return redirect()->route('cars.index')
            ->with('success', 'Mobil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        try {
            // Delete main image
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }

            // Delete gallery images
            if ($car->gallery) {
                foreach ($car->gallery as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $car->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting car'], 500);
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function statistics()
    {
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $soldCars = Car::where('status', 'sold')->count();
        $reservedCars = Car::where('status', 'reserved')->count();
        $featuredCars = Car::where('featured', true)->count();

        // Get brand statistics
        $brandStats = Car::selectRaw('brand, COUNT(*) as count')
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $brands = $brandStats->pluck('brand');
        $brandCounts = $brandStats->pluck('count');

        // Get recent cars
        $recentCars = Car::latest()->limit(6)->get();

        return view('dashboard', compact(
            'totalCars',
            'availableCars', 
            'soldCars',
            'reservedCars',
            'featuredCars',
            'brands',
            'brandCounts',
            'recentCars'
        ));
    }
}
