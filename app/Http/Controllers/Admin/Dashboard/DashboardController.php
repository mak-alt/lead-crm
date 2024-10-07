<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Website,
    User,
    Lead,
    Task,
    Team,
    LeadStage
};

class DashboardController extends Controller
{
    //show dashboard page
    public function index()
    {
        //get total users active
        $count_active_users = User::active()->count();

        //get total websites active
        $count_active_websites = Website::active()->count();

        //get total websites
        $count_total_websites = Website::count();

        //get total leads
        $count_total_leads = Lead::count();

        //get total teams active
        $count_total_teams = Team::active()->count();

        //get total tasks
        $count_total_tasks = Task::parent()->count();

        //get websites
        $websites = Website::active()->get();

        $data = [
            'count_active_users' => $count_active_users,
            'count_active_websites' => $count_active_websites,
            'count_total_websites' => $count_total_websites,
            'count_total_leads' => $count_total_leads,
            'count_total_teams' => $count_total_teams,
            'count_total_tasks' => $count_total_tasks,
            'websites' => $websites
        ];

        return inertia('Admin/Dashboard/Index',[
            'data' => $data
        ]);
    }

    //get single website dashboard data
    public function singleWebAnalytics(Request $request)
    {
        //fetch all lead stages with leads count
        $lead_stages = LeadStage::withCount('leads')->whereWebsiteId($request->website_id)->get();
        $teams = Team::withCount('members')->whereWebsiteId($request->website_id)->get();
        $leads = Lead::with(['stage', 'user', 'client'])->latest()->take(10)->whereWebsiteId($request->website_id)->get();
        $tasks = Task::with(['website','members','user','taskStage'])->parent()->latest()->take(10)->whereWebsiteId($request->website_id)->get();

        $data = [
            'lead_stages' => $lead_stages,
            'teams' => $teams,
            'leads' => $leads,
            'tasks' => $tasks
        ];

        return response()->json(['data' => $data]);
    }

    //show single website dashboard page
    public function singleDashboard(){
        $website = Website::findOrFail(core()->currentWebsite()->id);
        $lead_stages = LeadStage::withCount('leads')->whereWebsiteId(core()->currentWebsite()->id)->get();
        $recent_leads = Lead::with(['stage','user','client'])->whereWebsiteId(core()->currentWebsite()->id)->latest()->take(10)->get();
        $recent_tasks = Task::with(['taskStage','members'])->parent()->whereWebsiteId(core()->currentWebsite()->id)->latest()->take(10)->get();
        return inertia('Admin/Dashboard/Single',[
            'website' => $website,
            'lead_stages' => $lead_stages,
            'recent_leads' => $recent_leads,
            'recent_tasks' => $recent_tasks,
        ]);
    }
}
