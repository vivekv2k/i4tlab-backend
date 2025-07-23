<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }

        $users = User::all();

        foreach (range(1, 20) as $i) {
            Task::create([
                'title' => "Sample Task {$i}",
                'description' => Str::random(20),
                'due_date' => now()->addDays(rand(1, 30))->toDateString(),
                'status' => 'pending',
                'assigned_user_id' => $users->random()->id,
            ]);
        }
    }
}
