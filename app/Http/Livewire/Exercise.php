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
        // Initialize the reps in set input on the front-end to the last amount used (stored in the database)
        $this->repsInSet = $this->exercise->reps_in_set;

        $this->getTotalRepsToday();
        $this->updateTimeSinceLastSet();
    }

    public function render()
    {
        return view('livewire.exercise');
    }

    public function updateTimeSinceLastSet()
    {
        // Grab the most recent set of this exercise
        $set = $this->exercise->sets()->latest()->first();
        $this->timeSinceLastSet = $set->created_at->diffForHumans();
    }

    public function getTotalRepsToday()
    {
        /* Calculate the number of reps performed today */
        $date = new \DateTime('today');
        $this->repsToday = $this->exercise->sets()->whereDate('created_at', Carbon::today())->sum('reps');
    }

    public function updatedRepsInSet()
    {
        /* If the number of reps is not empty, update the exercise reps_in_set value */
        if(!empty($this->repsInSet)) {
            $this->exercise->update(['reps_in_set' => $this->repsInSet]);
        }
    }

    public function addSet()
    {
        /* Add a new set with the number of reps specified */
        Set::create([
            'exercise_id' => $this->exercise->id,
            'reps' => $this->repsInSet
        ]);

        $this->getTotalRepsToday();
        $this->updateTimeSinceLastSet();
    }
}
