<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Website,
    Team,
    Role,
    Media,
    LeadStage,
    LeadSource,
    Lead,
    Timezone
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        \DB::table('users')->delete();
        \DB::table('roles')->delete();
        \DB::table('timezones')->delete();
        // \DB::table('websites')->delete();
        // \DB::table('teams')->delete();
        // \DB::table('roles')->delete();
        // \DB::table('media')->delete();
        // \DB::table('lead_stages')->delete();
        // \DB::table('lead_sources')->delete();
        // \DB::table('leads')->delete();
        // User::factory(5)->has(Website::factory()->count(3)
        //                         ->has(LeadStage::factory()->count(3))
        //                         ->has(LeadSource::factory()->count(3)
        //                             ->has(Lead::factory()->count(4))
        //                         )
        //                     )
        //                 ->hasAttached(Team::factory()->count(3),['is_head' => 1|0],'teamMembers')
        //                 ->has(Role::factory()->count(4),'roles')
        //                 ->create();
        

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'status' => 1
        ]);

        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'status' => 1],
            ['name' => 'Partner', 'slug' => 'partner', 'status' => 1],
            ['name' => 'Sales Head', 'slug' => 'sales-head', 'status' => 1],
            ['name' => 'Sales', 'slug' => 'sales', 'status' => 1],
            ['name' => 'Production Head', 'slug' => 'production-head', 'status' => 1],
            ['name' => 'Production', 'slug' => 'production', 'status' => 1],
            ['name' => 'Client', 'slug' => 'client', 'status' => 1],
        ];

        foreach($roles as $role){
            Role::create($role);
        }

        $user->roles()->attach([Role::find(1)->id]);

        $timezones = [
            ['name' => 'America/New_York', 'timezone' => 'Eastern Time (US)', 'identifier' => 'GMT-05:00'],
            ['name' => 'America/Los_Angeles', 'timezone' => 'Pacific Time (US)', 'identifier' => 'GMT-08:00'],
            ['name' => 'America/Denver', 'timezone' => 'Mountain Time (US)', 'identifier' => 'GMT-07:00'],
            ['name' => 'America/Chicago', 'timezone' => 'Central Time (US)', 'identifier' => 'GMT-06:00'],
        ];

        foreach($timezones as $row){
            Timezone::create($row);
        }
    }
}
