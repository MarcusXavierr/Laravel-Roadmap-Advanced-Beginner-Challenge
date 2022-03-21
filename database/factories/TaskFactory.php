<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;
use NunoMaduro\Collision\Adapters\Phpunit\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = collect([Status::Open, Status::Archived, Status::Finished]);
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(),
            'status' => $status->random(),
        ];
    }
}
