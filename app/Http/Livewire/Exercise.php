<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use \App\Models\Set;
use Livewire\Component;

class Exercise extends Component
{

    public $exercise;
    public $repsToday;
    public $repsInSet;
    public $timeSinceLastSet;

    public function mount()
    {
        // Store the reps_in_set from the exericse model in public property for wire:model binding
        $this->repsInSet = $this->exercise->reps_in_set;

        $this->getRepsToday();
        $this->getTimeSinceLastSet();
    }

    public function render()
    {
        return view('livewire.exercise');
    }

    public function getTimeSinceLastSet()
    {
        $set = $this->exercise->sets->last();
        $this->timeSinceLastSet = $set->created_at->diffForHumans();
    }

    public function getRepsToday()
    {
        $today = Carbon::today();
        $this->repsToday = $this->exercise->sets->where('created_at', '>=', $today->startOfDay())->where('created_at', '<=', $today->endOfDay())->sum('reps');
    }

    public function updatedRepsInSet()
    {
        // Update the reps_in_set for this exercise if the inputted value is not null
        if(!empty($this->repsInSet)) {
            $this->exercise->update(['reps_in_set' => $this->repsInSet]);
        }
    }

    public function addSet()
    {
        Set::create([
            'exercise_id' => $this->exercise->id,
            'reps' => $this->repsInSet
        ]);

        // Refresh the model in Livewire since we eager loaded this exercise
        $this->exercise = $this->exercise->refresh();

        $this->getRepsToday();
        $this->getTimeSinceLastSet();
    }
}
