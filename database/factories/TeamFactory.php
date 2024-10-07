<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Website;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $name = fake()->name();
        $users = collect(User::all()->modelKeys());
        $websites = collect(Website::all()->modelKeys());
        return [
            'name' => $name,
            'slug' => \Str::slug($name),
            'user_id' => $users->random(),
            'website_id' => $websites->random()
        ];
    }
}
