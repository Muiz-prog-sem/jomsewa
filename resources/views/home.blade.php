@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<header class="bg-gray-900 text-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-center min-h-screen">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold mb-4">
                Welcome to Jom Sewa Car Rentals
            </h1>
            <p class="text-lg mb-8">
                Your one-stop place for smart car rentals.
            </p>
            <a href="#main" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300">
                Explore More
            </a>
        </div>
    </div>
</header>
<main id="main">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!--<center><em><strong>Explore our collection of cars, which includes options such as sedans, hatchbacks, and beyond.</center>-->
            <div class="flex justify-center">
                <!-- Image 1 -->
                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                    <div class="relative">
                        <img src="{{ asset('img/image1.jpg') }}" alt="Image 1" class="rounded-lg shadow-md h-auto max-w-full custom-image-size">
                        <div class="absolute bottom-0 left-0 right-20 p-4">
                            <h3 class="text-white text-lg font-bold text-center">Hatchback</h3>
                        </div>
                    </div>
                </div>
                <!-- Image 2 -->
                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                    <div class="relative">
                        <img src="{{ asset('img/image2.jpg') }}" alt="Image 2" class="rounded-lg shadow-md h-auto max-w-full custom-image-size">
                        <div class="absolute bottom-0 left-0 right-10 p-4">
                            <h3 class="text-white text-lg font-bold text-center">Sedan</h3>
                        </div>
                    </div>
                </div>
                <!-- Image 3 -->
                <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
                    <div class="relative">
                        <img src="{{ asset('img/image3.jpg') }}" alt="Image 3" class="rounded-lg shadow-md h-auto max-w-full custom-image-size">
                        <div class="absolute bottom-0 left-0 right-10 p-4">
                            <h3 class="text-white text-lg font-bold text-center">MPV</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Make a Booking Button -->
            <div class="w-full text-center mt-6">
                <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300">Make a Booking</a>
            </div>
            <!-- End of Make a Booking Button -->
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .relative {
        position: relative;
    }
    .rounded-lg {
        border-radius: 0.5rem;
    }
    .shadow-md {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .custom-image-size {
        max-width: 100%; /* Adjust the max-width as needed */
        height: auto; /* Maintain aspect ratio */
    }
</style>
@endpush
