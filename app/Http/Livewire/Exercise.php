<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use \App\Models\Set;
use Livewire\Component;

class Exercise extends Component
{

    public $exercise;
    public $reps_today;
    public $reps_in_set;
    public $time_since_last_set;

    public function mount()
    {
        // Store the reps_in_set from the exericse model in public property for wire:model binding
        $this->reps_in_set = $this->exercise->reps_in_set;

        $this->getRepsToday();
        $this->getTimeSinceLastSet();
    }

    public function render()
    {
        return view('livewire.exercise');
    }

    public function getTimeSinceLastSet()
    {
        $set = $this->exercise->sets()->latest()->first();
        $this->time_since_last_set = $set->created_at->diffForHumans();
    }

    public function getRepsToday()
    {
        $date = new \DateTime('today');
        $this->reps_today = $this->exercise->sets()->whereDate('created_at', Carbon::today())->sum('reps');
    }

    public function updatedRepsInSet()
    {
        // Update the reps_in_set for this exercise if the inputted value is not null
        if(!empty($this->reps_in_set)) {
            $this->exercise->update(['reps_in_set' => $this->reps_in_set]);
        }
    }

    public function addSet()
    {
        Set::create([
            'exercise_id' => $this->exercise->id,
            'reps' => $this->reps_in_set
        ]);

        $this->getRepsToday();
        $this->getTimeSinceLastSet();
    }
}
