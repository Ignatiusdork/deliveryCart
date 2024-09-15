<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-center items-start min-h-[3rem]">
            <a href="{{ route('products.index') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-3 px-6 rounded text-lg mt-4">
                View Products
            </a>
            <a href="{{ route('account.overview', auth()->id()) }}" class="bg-green-500 hover:bg-green-700 text-black font-bold py-3 px-6 rounded text-lg mt-4">
                Account Overview
            </a>
        </div>
    </x-slot>

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-800">
                        {{ __("Welcome to Ofon's Shop Cart") }}
                    </div>
                </div>
            </div>
        </div>
    @endsection

</x-app-layout>
