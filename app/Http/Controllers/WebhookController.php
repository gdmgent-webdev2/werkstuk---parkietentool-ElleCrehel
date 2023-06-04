<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Mollie\Laravel\Facades\Mollie;

class WebhookController extends Controller
{
    public function mollie(Request $request)
    {
        $payload = $request->all();

        // Retrieve the order ID from the metadata
        $order_id = $payload['metadata']['order_id'];

        // Get the order from the database
        $order = Order::find($order_id);

        // Check if the order exists
        if ($order) {
            // Update the order status with the Mollie payment status
            $order->status = $payload['status'];
            $order->save();

            // Additional logic or actions based on the payment status
            if ($payload['status'] === 'paid') {
                // Payment is successful, perform actions accordingly
            } elseif ($payload['status'] === 'cancelled') {
                // Payment is cancelled, perform actions accordingly
            }
        }

        // Return a response to Mollie
        return response()->json(['success' => true]);
    }
}
