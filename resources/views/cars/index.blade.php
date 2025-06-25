@extends('layouts.app')

@section('title', 'Luxury Cars - Showroom')

@section('content')
    <div x-data="carIndex()" class="space-y-6">
        @if ($errors->any())
            <div class="bg-red-500/90 text-white p-4 rounded-lg shadow-lg animate-fade-in mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Header -->
        <div class="gradient-bg rounded-2xl p-8 text-center">
            <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                Luxury Car Collection
            </h1>
            <p class="text-gray-300 text-lg">Discover our exclusive collection of premium vehicles</p>
        </div>

        <!-- Search and Filters -->
        <div class="glass rounded-xl p-6">
            <form method="GET" action="{{ route('cars.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search cars..."
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Brand Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Brand</label>
                        <select name="brand"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select name="status"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved
                            </option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Sort By</label>
                        <select name="sort_by"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Latest
                            </option>
                            <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                            <option value="year" {{ request('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
                            <option value="brand" {{ request('sort_by') == 'brand' ? 'selected' : '' }}>Brand</option>
                        </select>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Min Price</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min price"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Max Price</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max price"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-2 rounded-lg transition-all duration-300 transform hover:scale-105">
                        Apply Filters
                    </button>
                    <a href="{{ route('cars.index') }}" class="text-gray-400 hover:text-white transition-colors">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="flex justify-between items-center">
            <p class="text-gray-300">
                Showing {{ $cars->firstItem() ?? 0 }} to {{ $cars->lastItem() ?? 0 }} of {{ $cars->total() }} cars
            </p>
            <div class="flex space-x-2">
                <button onclick="exportPDF()"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Export PDF
                </button>
            </div>
        </div>

        <!-- Cars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @forelse ($cars as $car)
                <div
                    class="glass card-hover rounded-lg shadow-lg overflow-hidden transition-all duration-300 animate-fade-in relative border border-gray-700">
                    <div class="relative h-48">
                        @if ($car->image)
                            <img src="{{ Storage::url($car->image) }}" alt="{{ $car->full_name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center skeleton">
                                <i class="fas fa-car text-4xl text-gray-400 animate-pulse"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            @if ($car->featured)
                                <span
                                    class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-2 py-1 rounded-lg text-xs font-bold shadow-lg animate-pulse-slow">
                                    <i class="fas fa-star mr-1"></i>Featured
                                </span>
                            @endif
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                            <h3 class="text-white text-xl font-bold drop-shadow">{{ $car->full_name }}</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold text-blue-400">{{ $car->formatted_price }}</span>
                            <span
                                class="text-xs px-2 py-1 rounded-full font-semibold shadow {{ $car->status === 'available' ? 'bg-green-500 text-white' : ($car->status === 'sold' ? 'bg-red-500 text-white' : 'bg-yellow-400 text-gray-900') }} animate-fade-in">
                                {{ ucfirst($car->status) }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-400 mb-4">
                            <div><i class="fas fa-calendar mr-2"></i>{{ $car->year }}</div>
                            <div><i class="fas fa-tachometer-alt mr-2"></i>{{ number_format($car->mileage) }} km</div>
                            <div><i class="fas fa-gas-pump mr-2"></i>{{ $car->fuel_type }}</div>
                            <div><i class="fas fa-cog mr-2"></i>{{ $car->transmission }}</div>
                        </div>
                        <div class="flex justify-between">
                            <a href="{{ route('cars.show', $car) }}"
                                class="text-blue-500 hover:text-blue-700 font-semibold transition">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                            <div class="flex space-x-2">
                                <a href="{{ route('cars.edit', $car) }}"
                                    class="text-yellow-500 hover:text-yellow-700 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition"
                                        onclick="return confirm('Are you sure you want to delete this car?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-car text-6xl text-gray-300 mb-4 animate-pulse"></i>
                    <h3 class="text-2xl font-bold text-gray-500">No cars available</h3>
                    <p class="text-gray-400">Start by adding a new car to the showroom.</p>
                </div>
            @endforelse
        </div>

        <!-- Loading Skeleton -->
        <div x-show="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @for ($i = 0; $i < 8; $i++)
                <div class="glass rounded-xl overflow-hidden">
                    <div class="skeleton h-48"></div>
                    <div class="p-6 space-y-4">
                        <div class="skeleton h-6 w-3/4"></div>
                        <div class="space-y-2">
                            <div class="skeleton h-4 w-full"></div>
                            <div class="skeleton h-4 w-2/3"></div>
                            <div class="skeleton h-4 w-1/2"></div>
                        </div>
                        <div class="skeleton h-8 w-full"></div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Pagination -->
        @if ($cars->hasPages())
            <div class="flex justify-center">
                <div class="glass rounded-lg p-4">
                    {{ $cars->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ showDeleteModal: false, carId: null }" x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="glass rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold text-white mb-4">Confirm Delete</h3>
            <p class="text-gray-300 mb-6">Are you sure you want to delete this car? This action cannot be undone.</p>
            <div class="flex space-x-4">
                <button @click="showDeleteModal = false"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 rounded-lg transition-colors">
                    Cancel
                </button>
                <button @click="confirmDelete()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function carIndex() {
                return {
                    loading: false,

                    deleteCar(carId) {
                        this.carId = carId;
                        this.showDeleteModal = true;
                    },

                    confirmDelete() {
                        this.loading = true;
                        fetch(`/cars/${this.carId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showToast('Car deleted successfully!', 'success');
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    showToast('Error deleting car', 'error');
                                }
                            })
                            .catch(error => {
                                showToast('Error deleting car', 'error');
                            })
                            .finally(() => {
                                this.loading = false;
                                this.showDeleteModal = false;
                            });
                    }
                }
            }

            function exportPDF() {
                showToast('PDF export feature coming soon!', 'success');
            }
        </script>
    @endpush
@endsection
