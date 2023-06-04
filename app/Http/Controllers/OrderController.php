<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ring;
use App\Models\Order;

use Illuminate\Support\Facades\Validator;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function view()
    {
        $user = Auth::user();
    
        // Check if the user has paid membership
        if ($user->membership_paid !== 'yes') {
            return redirect()->back()->with('error', "You don't have an active membership. Please pay the membership fee first.");
        }
    
        $rings = Ring::all();
        $user_id = $user->id;
        $user_name = $user->name;
        $user_email = $user->email;
        $user_lidnumber = $user->lidnumber;
    
        return view('orders.order', compact('rings', 'user_id', 'user_name', 'user_email', 'user_lidnumber'));
    }
    

    public function previousOrders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::where('user_id', $user_id)->get();
        return view('orders.previousorders', compact('orders'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ring_name' => 'required',
            'ring_size' => 'required|regex:/^\d+(\.\d{1})?$/',
            'status' => 'required|in:besteld,betaald,open',
        ]);

        $ring = Ring::where('name', $request->input('ring_name'))->first();
        if (!$ring) {
            return redirect()->back()->withErrors(['ring_name' => 'Invalid ring selected.'])->withInput();
        }

        $price = number_format($ring->price, 2, '.', '');

        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'ring_name' => $request->input('ring_name'),
            'ring_size' => $request->input('ring_size'),
            'status' => $request->input('status'),
            'user_name' => $request->input('user_name'),
            'lidnumber' => $request->input('lidnumber'),
            'price' => $price,
        ]);

        $webhook_url = "https://6ee7-94-110-57-3.ngrok-free.app/webhooks/mollie";

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $price,
            ],
            "description" => "Payment for order #" . $order->id,
            "redirectUrl" => route('orders.confirmation'),
            "webhookUrl" => $webhook_url,
            "metadata" => [
                "order_id" => $order->id,
                'user_id' => $request->input('user_id'),
                'ring_name' => $request->input('ring_name'),
                'ring_size' => $request->input('ring_size'),
                'status' => $request->input('status'),
                'user_name' => $request->input('user_name'),
                'lidnumber' => $request->input('lidnumber'),
                'price' => $price,
            ],
        ]);

        $order->status = $request->input('status');
        $order->save();

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function succes()
    {
        return view('orders.confirmation');
    }
 
    public function showMembershipAlert()
    {
        $user = Auth::user();
    
        // Check if the user has not paid for the membership
        if ($user->membership_paid !== 'yes') {
            $alertMessage = 'You need to pay for the membership before placing an order.';
            return view('orders.membership_alert', compact('alertMessage'));
        }
    
        // User has already paid for the membership, redirect to the order view
        return redirect()->route('orders.view');
    }
    
}
