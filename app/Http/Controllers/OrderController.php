<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ring;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function view() {

      $rings = Ring::all();
      $user_id = Auth::user()->id;
      $user_name = Auth::user()->name;
      $user_email = Auth::user()->email;
      $user_lidnumber = Auth::user()->lidnumber;

      return view('orders.order', compact('rings','user_id','user_name','user_email','user_lidnumber'));
    }

    public function create(Request $request)
    {
      $validate = $request->validate([
        'ring_name' => 'required',
        'ring_size' => 'required|regex:/^\d+(\.\d{1})?$/',
        'user_id' => 'required',
      ]);
      
        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'ring_name' => $request->input('ring_name'),
            'ring_size' => $request->input('ring_size'),
        ]);

        

        return redirect()->route('orders.confirmation');
    }
}