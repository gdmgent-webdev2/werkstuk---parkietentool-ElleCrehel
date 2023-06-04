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

    public function payMembershipFee()
    {
        $user = Auth::user();
        // Add logic to check if the user has already paid the membership fee this year
        // If already paid, show a message or redirect to a different page
        
        // Generate a unique payment description or invoice number
        $paymentDescription = 'Membership Fee';

        return view('profile.payment', compact('user', 'paymentDescription'));
    }

    public function processPayment()
    {
        $user = Auth::user();
        $amount = 50; // Amount in euros for the membership fee

        // Generate a unique payment description or invoice number
        $paymentDescription = 'Membership Fee';

        $payment = Mollie::api()->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($amount, 2, '.', ''),
            ],
            'description' => $paymentDescription,
            'redirectUrl' => route('profile.payment.confirmation'),
            'metadata' => [
                'user_id' => $user->id,
                'payment_description' => $paymentDescription,
            ],
        ]);

        // Store the payment details in your database or session if needed
        // For example: $user->payments()->create(['amount' => $amount, 'payment_id' => $payment->id]);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function paymentConfirmation()
    {
        $user = Auth::user();
        // Show a confirmation message or redirect to a success page

        return view('profile.payment_confirmation', compact('user'));
    }
}
