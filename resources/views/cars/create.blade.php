@extends('layouts.app')

@section('title', 'Add New Car - Luxury Car Showroom')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="gradient-bg rounded-2xl p-8 text-center">
            <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                Add New Car
            </h1>
            <p class="text-gray-300 text-lg">Add a new luxury car to your showroom collection</p>
        </div>

        <!-- Create Form -->
        <div class="glass rounded-xl p-8 shadow-2xl animate-fade-in">
            <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="brand" class="block text-sm font-medium text-blue-400 mb-2">Brand *</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required
                            placeholder="e.g., Mercedes-Benz, BMW, Audi"
                            class="w-full bg-gray-800 border border-blue-500 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow @error('brand') border-red-500 @enderror">
                        @error('brand')
                            <p class="mt-1 text-sm text-red-400 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-300 mb-2">Model *</label>
                        <input type="text" id="model" name="model" value="{{ old('model') }}" required
                            placeholder="e.g., S-Class, X5, A8"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('model') border-red-500 @enderror">
                        @error('model')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-300 mb-2">Year *</label>
                        <input type="number" id="year" name="year" value="{{ old('year') }}" min="1900"
                            max="{{ date('Y') + 1 }}" required placeholder="e.g., 2023"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('year') border-red-500 @enderror">
                        @error('year')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (IDR) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                            step="0.01" required placeholder="e.g., 1500000000"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-300 mb-2">Color *</label>
                        <input type="text" id="color" name="color" value="{{ old('color') }}" required
                            placeholder="e.g., Pearl White, Obsidian Black"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('color') border-red-500 @enderror">
                        @error('color')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="transmission" class="block text-sm font-medium text-gray-300 mb-2">Transmission
                            *</label>
                        <select id="transmission" name="transmission" required
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('transmission') border-red-500 @enderror">
                            <option value="">Select transmission</option>
                            <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic
                            </option>
                        </select>
                        @error('transmission')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fuel_type" class="block text-sm font-medium text-gray-300 mb-2">Fuel Type *</label>
                        <input type="text" id="fuel_type" name="fuel_type" value="{{ old('fuel_type') }}" required
                            placeholder="e.g., Petrol, Diesel, Hybrid"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fuel_type') border-red-500 @enderror">
                        @error('fuel_type')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-300 mb-2">Mileage (km) *</label>
                        <input type="number" id="mileage" name="mileage" value="{{ old('mileage') }}" min="0"
                            required placeholder="e.g., 15000"
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mileage') border-red-500 @enderror">
                        @error('mileage')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status *</label>
                        <select id="status" name="status" required
                            class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="">Select status</option>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-blue-400 mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4" required
                        placeholder="Describe the car's features, condition, and any special details..."
                        class="w-full bg-gray-800 border border-blue-500 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-400 animate-pulse">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Featured -->
                <div class="flex items-center">
                    <input type="checkbox" id="featured" name="featured" value="1"
                        {{ old('featured') ? 'checked' : '' }}
                        class="w-4 h-4 text-yellow-500 bg-gray-800 border-blue-500 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="featured" class="ml-2 text-sm text-yellow-400 font-semibold">Mark as featured car <span
                            class="ml-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-2 py-0.5 rounded-full text-xs font-bold shadow">Featured</span></label>
                </div>
                <!-- Image Upload -->
                <div class="space-y-4">
                    <div>
                        <label for="image" class="block text-sm font-medium text-blue-400 mb-2">Main Image</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-blue-500 border-dashed rounded-lg hover:border-blue-400 transition-colors bg-gray-800/50 shadow">
                            <div class="space-y-1 text-center">
                                <div id="main-image-preview" class="mb-2"></div>
                                <svg class="mx-auto h-12 w-12 text-blue-400 animate-pulse" stroke="currentColor"
                                    fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="image"
                                        class="relative cursor-pointer bg-gray-800 rounded-md font-medium text-blue-400 hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" accept="image/*"
                                            class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-blue-300">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-400 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gallery" class="block text-sm font-medium text-blue-400 mb-2">Gallery Images</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-blue-500 border-dashed rounded-lg hover:border-blue-400 transition-colors bg-gray-800/50 shadow">
                            <div class="space-y-1 text-center">
                                <div id="gallery-preview" class="flex flex-wrap gap-2 justify-center mb-2"></div>
                                <svg class="mx-auto h-12 w-12 text-blue-400 animate-pulse" stroke="currentColor"
                                    fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="gallery"
                                        class="relative cursor-pointer bg-gray-800 rounded-md font-medium text-blue-400 hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload multiple files</span>
                                        <input id="gallery" name="gallery[]" type="file" accept="image/*" multiple
                                            class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-blue-300">PNG, JPG, GIF up to 2MB each</p>
                            </div>
                        </div>
                        @error('gallery.*')
                            <p class="mt-1 text-sm text-red-400 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-700 mt-8">
                    <a href="{{ route('cars.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors font-semibold shadow">
                        Cancel
                    </a>
                    <div class="flex space-x-4">
                        <button type="reset"
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg transition-colors font-semibold shadow">
                            Reset Form
                        </button>
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                            Add Car
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Preview main image
            const mainImageInput = document.getElementById('image');
            const mainImagePreview = document.getElementById('main-image-preview');
            mainImageInput.addEventListener('change', function(e) {
                mainImagePreview.innerHTML = '';
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        mainImagePreview.innerHTML =
                            `<img src="${e.target.result}" class='mx-auto rounded-lg shadow w-40 h-32 object-cover border-2 border-blue-400 mb-2'>`;
                    };
                    reader.readAsDataURL(file);
                }
            });
            // Preview gallery images
            const galleryInput = document.getElementById('gallery');
            const galleryPreview = document.getElementById('gallery-preview');
            galleryInput.addEventListener('change', function(e) {
                galleryPreview.innerHTML = '';
                Array.from(e.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'rounded-lg shadow w-24 h-20 object-cover border-2 border-blue-400';
                        galleryPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            });
        </script>
    @endpush
@endsection
