<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use TCPDF;

class EigendomsbewijzenController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->get();
        return view('orders.eigendomsbewijzen', compact('orders'));
    }

    public function generatePdf(Request $request)
    {
        $html = $request->input('html');
    
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output(public_path('eigendomsbewijzen.pdf'), 'F');
    
        return response()->json(['message' => 'PDF generated successfully']);
    }
    
}
