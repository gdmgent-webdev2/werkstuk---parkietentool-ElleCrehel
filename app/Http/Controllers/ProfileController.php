<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mollie\Laravel\Facades\Mollie;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{


    public function edit(Request $request): View
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $user_lidnumber = Auth::user()->lidnumber;
        $user_membership_paid = $user->membership_paid;

        return view('profile.edit', compact('user_id', 'user_name', 'user_email', 'user_lidnumber', 'user_membership_paid'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
    
        $user = $request->user();
        $user->fill($validatedData);
    
        if ($request->user()->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        return Redirect::route('profile.edit')->with('alert', [
            'type' => 'success',
            'message' => 'Profile updated successfully.',
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function payMembershipFee(Request $request)
    {
        $user = Auth::user();

    // Check if the user has already paid
    if ($user->membership_paid === 'yes') {
        return redirect()->back()->with('error', 'Membership is already paid and active.');
    }

    // Redirect to the membership payment page or display the membership alert
    return app(OrderController::class)->showMembershipAlert();
        // Calculate the membership fee amount
        $membershipFee = 50.00; // Example: Hardcoded membership fee amount
        $price = number_format($membershipFee, 2, '.', '');
    
        $webhookUrl = "https://6ee7-94-110-57-3.ngrok-free.app/webhooks/mollie"; // Replace with your actual webhook URL
    
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $price,
            ],
            "description" => "Membership Fee Payment",
            "redirectUrl" => route('profile.payment.confirmation'), // Replace with your payment confirmation route
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "user_id" => $user->id,
                "user_email" => $user->email,
            ],
        ]);
    
        // Update the membership_paid field to 'yes' directly in the database
        User::where('id', $user->id)->update(['membership_paid' => 'yes']);
    
        // Redirect the user to the Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }
    

    public function paymentConfirmation()

    {
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $user_lidnumber = Auth::user()->lidnumber;
     
      
        return view('profile.payment_confirmation', compact('user_id', 'user_name', 'user_email', 'user_lidnumber'));
        
    }

    public function checkout(Request $request)
    {
        // Perform the payment checkout process here
        return redirect()->route('profile.payment.confirmation');
    }
}
