<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExercisesTest extends TestCase
{
    use withFaker;
    use refreshDatabase;

    /** @test */
    public function a_user_can_create_a_test()
    {
        $attributes = [
            'name' => $this->faker->word
        ];

        $this->post('/exercises', $attributes)->assertRedirect('/exercises');
        $this->assertDatabaseHas('exercises', $attributes);

        $this->get('/exercises')->assertSee($attributes['name']);
    }
}
