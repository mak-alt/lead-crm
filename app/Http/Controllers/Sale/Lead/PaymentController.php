<?php

namespace App\Http\Controllers\Sale\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    LeadPayment
};

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $this->validateRequest();
        
        $payment = new LeadPayment();
        $payment->lead_id = $request->lead_id;
        $payment->user_id = auth()->user()->id;
        $payment->amount = $request->amount;
        $payment->date = $request->date;
        $payment->mode = $request->mode;
        $payment->save();

        if($payment){
            return back()->withSuccess('Payment Created Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $id)
    {
        if($id){
            $payment = LeadPayment::find($id);
            $payment->status = 0;
            $payment->save();

            if($payment){
                return back()->withSuccess('Payment Refund Successfully :)');
            }
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    /**
     * create partial refunds
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refundPartialPayment(Request $request, $slug)
    {
        $this->validateRequest();

        //check paid payment for lead
        $paid = LeadPayment::whereLeadId($request->lead_id)->whereStatus(1)->sum('amount');
        $refund = LeadPayment::whereLeadId($request->lead_id)->whereStatus(0)->sum('amount');
        $paid = floatval($paid) - floatval($refund); 
        if($paid == 0){
            return back()->withError('You donot have any payment paid yet.');
        }
        if(floatval($paid) < floatval($request->amount)){
            return back()->withError('Please enter refundable payment less than payment paid.');
        }
        $payment = new LeadPayment();
        $payment->lead_id = $request->lead_id;
        $payment->user_id = auth()->user()->id;
        $payment->amount = $request->amount;
        $payment->date = $request->date;
        $payment->mode = $request->mode;
        $payment->status = 0;
        $payment->save();

        if($payment){
            return back()->withSuccess('Partial Payment Refunded Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validate Request
     */
    private function validateRequest()
    {
        request()->validate([
            'amount' => 'required|numeric',
            'date' => 'required'
        ]);
    }
}
