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
        // Initialize query for menus with eager loading of the merchant
        $query = Menu::with('merchant'); // Assuming Menu has a merchant relationship

        // Apply search criteria if present
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%")
                ->orWhere('description',
                    'LIKE',
                    "%$searchTerm%"
                )
                ->orWhere('price', 'LIKE', "%$searchTerm%");
            });
        }

        // Fetch the filtered menus
        $menus = $query->get();

        return view('customer.dashboard', compact('menus'));
    }



    // Menampilkan daftar menu
    public function menuList()
    {
        $menus = Menu::all(); // Mengambil semua menu dari database
        return view('customer.menu-list', compact('menus'));
    }

    // Menampilkan formulir pemesanan
    public function orderForm($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        return view('customer.order-form', compact('menu'));
    }

    // Menyimpan pesanan
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
        $order->status = 'pending'; // Status awal pesanan
        $order->save();

        return redirect()->route('customer.dashboard')->with('success', 'Order placed successfully.');
    }

    public function orderList()
    {
        $orders = auth()->user()->orders;
        return view('customer.orders', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function orderDetails(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.order-details', compact('order'));
    }

    
    public function createOrder(Request $request)
    {
        $menus = Menu::all();
        $menu_id = $request->input('menu_id');

        return view('customer.order-create', compact('menu_id','menus'));
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

    public function viewOrders()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('customer.orders', compact('orders'));
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
            // Add other fields as necessary
        ]);

        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->alamat = $request->alamat;
        $customer->kontak = $request->kontak;
        $customer->deskripsi = $request->deskripsi;

        // Update other fields as necessary

        $customer->save();

        return redirect()->route('customer.edit-profile')->with('success', 'Profile updated successfully.');
    }

    

}
