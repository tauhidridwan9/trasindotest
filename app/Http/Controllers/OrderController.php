<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Order;

class OrderController extends Controller
{
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Periksa apakah user memiliki hak untuk menghapus order ini
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();

        return redirect()->route('customer.order.list')->with('success', 'Order deleted successfully.');
    }

    

    public function checkout(Request $request, Order $order)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->quantity * $order->menu->price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->kontak,
            ],
            'item_details' => [
                [
                    'id' => $order->menu->id,
                    'price' => $order->menu->price,
                    'quantity' => $order->quantity,
                    'name' => $order->menu->name,
                ]
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('customer.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function complete(Request $request, Order $order)
    {
        $transactionStatus = Transaction::status($order->id);

        if ($transactionStatus->transaction_status == 'settlement') {
            $order->status = 'paid';
            $order->save();

            return redirect()->route('customer.dashboard')->with('success', 'Pembayaran pesanan berhasil.');
        }

        return redirect()->route('customer.dashboard')->with('error', 'Pembayaran gagal.');
    }


}
