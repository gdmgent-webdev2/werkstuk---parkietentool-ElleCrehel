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
    public function previousOrders(){
      $user_id = Auth::user()->id;
      $orders = Order::where('user_id', $user_id)->get();
      return view('orders.previousorders', compact('orders')); }

    public function create(Request $request)
    {
      $validate = $request->validate([
        'ring_name' => 'required',
        'ring_size' => 'required|regex:/^\d+(\.\d{1})?$/',
        'user_id' => 'required',
        'status' => 'required',
        'user_name' => 'required',
        'lidnumber' => 'required',
      ]);
      
        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'ring_name' => $request->input('ring_name'),
            'ring_size' => $request->input('ring_size'),
            'status' => $request->input('status'),
            'user_name' => $request->input('user_name'),
            'lidnumber' => $request->input('lidnumber'),
        ]);

        

        return redirect()->route('orders.confirmation');
    }

  
}