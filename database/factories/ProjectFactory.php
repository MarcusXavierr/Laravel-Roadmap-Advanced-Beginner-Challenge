<?php

namespace Database\Factories;

use App\Enums\Status;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use NunoMaduro\Collision\Adapters\Phpunit\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'deadline' => CarbonImmutable::make('2023-01-01'),
            'client_id' => 1
        ];
    }
}
