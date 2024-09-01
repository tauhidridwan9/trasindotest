<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Menampilkan dashboard customer
    public function dashboard(Request $request)
    {
        $query = Menu::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
            ->orWhere('description', 'like', '%' . $request->input('search') . '%');
            
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        $menus = $query->get();

        return view('customer.dashboard', [
                'menus' => $menus,
            
            ]);
    }




   
    public function menuList()
    {
        $menus = Menu::all(); 
        return view('customer.menu-list', compact('menus'));
    }

    
    public function orderForm($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        return view('customer.order-form', compact('menu'));
    }

    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string|max:255',
        ]);

        $order = new Order();
        $order->menu_id = $request->menu_id;
        $order->customer_id = auth()->id();
        $order->quantity = $request->quantity;
        $order->delivery_address = $request->delivery_address;
        $order->status = 'pending'; 

        return redirect()->route('customer.dashboard')->with('success', 'Order placed successfully.');
    }

    public function orderList()
    {
        $orders = auth()->user()->orders;
        return view('customer.orders', compact('orders'));
    }

   


   
    public function orderDetails(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.order-details', compact('order'));
    }

    
    public function createOrder($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        return view('customer.order-create', compact('menu'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date',
            'delivery_address' => 'required|string|max:255',
        ]);

        $order = new Order();
        $order->menu_id = $request->menu_id;
        $order->quantity = $request->quantity;
        $order->user_id = auth()->id(); 
        $order->delivery_date = $request->delivery_date;
        $order->delivery_address = $request->delivery_address;
        $order->save();

        return redirect()->route('customer.dashboard')->with('success', 'Order placed successfully.');
    }

    public function showInvoice($id)
    {
        $order = Order::findOrFail($id);
        return view('customer.invoice', compact('order'));
    }

    

    public function confirmOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

      
        if ($order->status !== 'delivered') {
            return redirect()->route('customer.order.list')->with('error', 'Only delivered orders can be confirmed.');
        }

       
        $order->status = 'confirmed';
        $order->save();

     
        return redirect()->route('customer.order.list')->with('success', 'Order has been confirmed.');
    }

    public function viewOrders()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        $orders->each(function ($order) {
            $order->total_price = $order->quantity * $order->menu->price;
        });
        return view('customer.orders', compact('orders'));
    }

    public function checkOut($id){
        $checkout = Order::findOrFail($id);

        if($order->user_id !== auth()->id()){
                abort(403, 'Tidak diizinkan');
        }


    }

    public function editProfile()
    {
        $customer = Auth::user();

        return view('customer.edit-profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
          
        ]);

        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->alamat = $request->alamat;
        $customer->kontak = $request->kontak;
        $customer->deskripsi = $request->deskripsi;

      

        $customer->save();

        return redirect()->route('customer.edit-profile')->with('success', 'Profile updated successfully.');
    }

    

}
