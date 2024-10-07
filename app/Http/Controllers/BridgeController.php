<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class BridgeController extends Controller
{
    public function make($slug) {
        $website = Website::where('slug',$slug)->first();

        if($website){
            core()->setSession(['website_session' => $website]);
            if(auth()->user()->isSuperAdmin()){
                return redirect()->route('admin.single.dashboard',$website->slug);
            }
            if(auth()->user()->isPartner()){
                return redirect()->route('partner.single.dashboard',$website->slug);
            }
            if(auth()->user()->isSalesHead()){
                return redirect()->route('saleshead.single.dashboard',$website->slug);
            }
            if(auth()->user()->isSales()){
                return redirect()->route('sales.single.dashboard',$website->slug);
            }
            if(auth()->user()->isProductionHead()){
                return redirect()->route('prodhead.single.dashboard',$website->slug);
            }
            if(auth()->user()->isProduction()){
                return redirect()->route('prod.single.dashboard',$website->slug);
            }
            if(auth()->user()->isClient()){
                return redirect()->route('client.single.dashboard',$website->slug);
            }
        }

        abort(404);
    }
}
