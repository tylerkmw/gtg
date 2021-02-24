<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exercises') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="flex m-5 justify-between">
                <h1 class="text-lg flex">Exercises Today</h1>
                <a type="button" href="/exercises/create" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    + Exercise
                </a>
            </div>

                @foreach($exercises as $exercise)
                    <livewire:exercise :exercise="$exercise" :key="$exercise->id"/>
                @endforeach



            </div>
        </div>
    </div>
</x-app-layout>
