<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Website;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
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
        $types = collect(['png','pdf','doc','jpg','csv']);
        return [
            'name' => $name,
            'type' => $types->random(),
            'size' => '500x500',
            'alt' => $name,
            'website_id' => $websites->random()
        ];
    }
}
