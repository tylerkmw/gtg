<div>
    <div class="bg-gray-200 p-5 w-1/3 m-5">
        <h1>{{ $exercise->name }}</h1>
        <h1 class="font-bold">Reps Today: {{ $repsToday }}</h1>
        <h1 wire:poll.10000ms="getTimeSinceLastSet">Last set {{ $timeSinceLastSet }}</h1>
        <input type="number" wire:model="repsInSet">
        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click="addSet()">
            + Set
        </button>
    </div>
</div>
