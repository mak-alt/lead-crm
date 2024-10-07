<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Website;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeadStage>
 */
class LeadStageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name();
        $websites = collect(Website::all()->modelKeys());
        return [
            'name' => $name,
            'slug' => \Str::slug($name),
            'color' => rand(1111,9999),
            'sort' => 0,
            'website_id' => $websites->random()
        ];
    }
}
