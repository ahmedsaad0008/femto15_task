<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function payment()
    {
        $availablePlans =[
           'task_monthly' => "monthly",
           'task_yearly' => "yearly",
        ];
        $data = [
            'intent' => auth()->user()->createSetupIntent(),
            'plans'=> $availablePlans
        ];
        return view('payment')->with($data);
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->payment_method;

        $planId = $request->plan;
        $user->newSubscription('main', $planId)->create($paymentMethod);

        return response([
            'success_url'=> redirect()->intended('/')->getTargetUrl(),
            'message'=>'success'
        ]);
    }
}
