@extends('layouts.app')

@section('title', $car->full_name . ' - Luxury Car Showroom')

@section('content')
    <div class="space-y-6">
        @if ($errors->any())
            <div class="bg-red-500/90 text-white p-4 rounded-lg shadow-lg animate-fade-in mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('cars.index') }}" class="text-gray-400 hover:text-white transition-colors">
                        Cars
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-300 md:ml-2">{{ $car->brand }} {{ $car->model }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Car Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="glass rounded-xl overflow-hidden relative">
                    @if ($car->image)
                        <img src="{{ Storage::url($car->image) }}" alt="{{ $car->full_name }}"
                            class="w-full h-96 object-cover transition-all duration-500 hover:scale-105 hover:shadow-2xl">
                    @else
                        <div class="w-full h-96 bg-gray-700 flex items-center justify-center skeleton">
                            <svg class="w-24 h-24 text-gray-500 animate-pulse" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif
                    @if ($car->featured)
                        <span
                            class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse-slow z-10">
                            <i class="fas fa-star mr-1"></i>Featured
                        </span>
                    @endif
                </div>

                <!-- Gallery Images -->
                @if ($car->gallery && count($car->gallery) > 0)
                    <div class="glass rounded-xl p-4 animate-fade-in">
                        <h3 class="text-lg font-semibold text-white mb-4">Gallery</h3>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($car->gallery as $image)
                                <div class="aspect-square rounded-lg overflow-hidden group relative shadow-lg">
                                    <img src="{{ Storage::url($image) }}" alt="Gallery image"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110 group-hover:brightness-75">
                                    <span
                                        class="absolute bottom-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded opacity-80 group-hover:opacity-100 transition">Gallery</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Car Information -->
            <div class="space-y-6">
                <!-- Header -->
                <div class="glass rounded-xl p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $car->brand }} {{ $car->model }}</h1>
                            <p class="text-gray-400">{{ $car->year }} • {{ $car->color }}</p>
                        </div>
                        <div class="flex space-x-2">
                            @if ($car->status == 'available')
                                <span
                                    class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Available</span>
                            @elseif($car->status == 'sold')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">Sold</span>
                            @else
                                <span
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">Reserved</span>
                            @endif

                            @if ($car->featured)
                                <span
                                    class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-medium">Featured</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-4xl font-bold text-blue-400 mb-6">
                        {{ $car->formatted_price }}
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <a href="{{ route('cars.edit', $car) }}"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                            <i class="fas fa-edit mr-2"></i>Edit Car
                        </a>
                        <form action="{{ route('cars.destroy', $car) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold"
                                onclick="return confirm('Are you sure you want to delete this car?')">
                                <i class="fas fa-trash mr-2"></i>Delete Car
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="glass rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Specifications</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Brand:</span>
                            <span class="text-white font-medium">{{ $car->brand }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Model:</span>
                            <span class="text-white font-medium">{{ $car->model }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Year:</span>
                            <span class="text-white font-medium">{{ $car->year }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Color:</span>
                            <span class="text-white font-medium">{{ $car->color }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Transmission:</span>
                            <span class="text-white font-medium">{{ $car->transmission }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Fuel Type:</span>
                            <span class="text-white font-medium">{{ $car->fuel_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Mileage:</span>
                            <span class="text-white font-medium">{{ number_format($car->mileage) }} km</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Status:</span>
                            <span class="text-white font-medium capitalize">{{ $car->status }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="glass rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Description</h3>
                    <p class="text-gray-300 leading-relaxed">{{ $car->description }}</p>
                </div>

                <!-- Contact Information -->
                <div class="glass rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Interested in this car?</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-gray-300">+62 812-3456-7890</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-gray-300">info@luxuryshowroom.com</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-300">Jl. Sudirman No. 123, Jakarta Pusat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Cars -->
        <div class="glass rounded-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Similar Cars</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($similarCars ?? [] as $similarCar)
                    <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-3">
                            @if ($similarCar->image)
                                <img src="{{ Storage::url($similarCar->image) }}" alt="{{ $similarCar->brand }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="text-white font-medium">{{ $similarCar->brand }} {{ $similarCar->model }}</h4>
                                <p class="text-gray-400 text-sm">{{ $similarCar->year }} • {{ $similarCar->color }}</p>
                                <p class="text-blue-400 font-medium">{{ $similarCar->formatted_price }}</p>
                            </div>
                            <a href="{{ route('cars.show', $similarCar) }}"
                                class="text-blue-400 hover:text-blue-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-400">No similar cars found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function deleteCar(carId) {
                if (confirm('Are you sure you want to delete this car?')) {
                    fetch(`/cars/${carId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Car deleted successfully!', 'success');
                                setTimeout(() => {
                                    window.location.href = '{{ route('cars.index') }}';
                                }, 1000);
                            } else {
                                showToast('Error deleting car', 'error');
                            }
                        })
                        .catch(error => {
                            showToast('Error deleting car', 'error');
                        });
                }
            }
        </script>
    @endpush
