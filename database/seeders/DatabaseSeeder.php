<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'is_admin' => true

        ]);

        Client::factory(5)->create()->each(function ($client) {
            Project::factory(2)->create(['client_id' => $client->id])
                ->each(function ($project) {
                    Task::factory(3)->create([
                        'user_id' => $this->user->id,
                        'project_id' => $project->id
                    ]);
                });
        });
    }
}
