<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    LeadStage,
    LeadSource,
    Website,
    User
};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name();
        $email = fake()->safeEmail();
        $phone = fake()->randomDigit();
        $description = fake()->text($maxNbChars = 300); ;
        $due_date = \Carbon\Carbon::now()->addDays(10);
        $lead_stages = collect(LeadStage::all()->modelKeys());
        $lead_sources = collect(LeadSource::all()->modelKeys());
        $websites = collect(Website::all()->modelKeys());
        $users = collect(User::all()->modelKeys());
        return [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'description' => $description,
            'due_date' => $due_date,
            'lead_stage_id' => $lead_stages->random(),
            'lead_source_id' => $lead_sources->random(),
            'website_id' => $websites->random(),
            'user_id' => $users->random()
        ];
    }
}
