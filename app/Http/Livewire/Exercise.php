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
        // Initialize the reps in set input on the front-end to the last amount used (stored in the database)
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
        // Grab the most recent set of this exercise
        $set = $this->exercise->sets()->latest()->first();
        $this->time_since_last_set = $set->created_at->diffForHumans();
    }

    public function getRepsToday()
    {
        /* Calculate the number of reps performed today */
        $date = new \DateTime('today');
        $this->reps_today = $this->exercise->sets()->whereDate('created_at', Carbon::today())->sum('reps');
    }

    public function updatedRepsInSet()
    {
        /* If the number of reps is not empty, update the exercise reps_in_set value */
        if(!empty($this->reps_in_set)) {
            $this->exercise->update(['reps_in_set' => $this->reps_in_set]);
        }
    }

    public function addSet()
    {
        /* Add a new set with the number of reps specified */
        Set::create([
            'exercise_id' => $this->exercise->id,
            'reps' => $this->reps_in_set
        ]);

        $this->getRepsToday();
        $this->getTimeSinceLastSet();
    }
}
