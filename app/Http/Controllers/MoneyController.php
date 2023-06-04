<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mollie\Laravel\Facades\Mollie;

class MoneyController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $user_lidnumber = Auth::user()->lidnumber;

        return view('money.index', compact('user_id', 'user_name', 'user_email', 'user_lidnumber'));
    }

    public function earn(Request $r)
    {
        //dd($r);

        $price = $r->price;
        $price = (string) number_format($price, 2, '.', '');

        $webhook_url = "https://6ee7-94-110-57-3.ngrok-free.app/webhooks/mollie";

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $price
            ],
            "description" => "betaling bezig",
            "redirectUrl" => route('orders.confirmation'), // after payment
            "webhookUrl" => $webhook_url,
            "metadata" => [
                "order_id" => "12345",
                "person" => "testpersoon"
            ],
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function succes()
    {
        return view('orders.confirmation');
    }
}
