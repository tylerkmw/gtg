<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \App\Models\Set;

class Exercise extends Component
{

    public $exercise;
    public $reps;
    public $repsToday;
    public $time;

    public function mount()
    {
        $this->reps = $this->exercise->reps_in_set;
        $this->getTotalRepsToday();
        $this->updateTime();
    }

    public function render()
    {
        return view('livewire.exercise');
    }

    public function updateTime()
    {
        /* Find the most recent set */
        $set = Set::where('exercise_id', $this->exercise->id)->orderBy('id', 'desc')->first();
        $start = \Carbon\Carbon::parse($set->created_at);
        $end = \Carbon\Carbon::now();
        $totalDuration = $end->diffForHumans($start);
        $this->time = $totalDuration;
        // dd($totalDuration);
    }

    public function getTotalRepsToday()
    {
        /* Calculate the number of reps performed today */
        $date = new \DateTime('today');
        $sets = $this->exercise->sets()->where('created_at', '>=', $date->format('Y-m-d 00:00:00'))->where('created_at', '<=', $date->format('Y-m-d 23:59:59'))->get();
        $count = 0;
        foreach($sets as $set) {
            $count += $set->reps;
        }
        $this->repsToday = $count;
    }

    public function updatedReps()
    {
        /* If the number of reps is not empty, update the exercise reps_in_set value */
        if(!empty($this->reps)) {
            $this->exercise->reps_in_set = $this->reps;
            $this->exercise->save();
        }
    }

    public function addSet()
    {
        /* Add a new set with the number of reps specified */
        Set::create([
            'exercise_id' => $this->exercise->id,
            'reps' => $this->reps
        ]);

        $this->getTotalRepsToday();
        $this->updateTime();
    }
}
