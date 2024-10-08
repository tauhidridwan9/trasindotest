<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    
    public function deliverOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

       
        if ($order->status !== 'paid') {
            return redirect()->route('merchant.orders')->with('error', 'Only paid orders can be delivered.');
        }

     
        $order->status = 'delivered';
        $order->save();

    
        return redirect()->route('merchant.orders')->with('success', 'Order has been delivered.');
    }


    public function dashboard()
    {
        $merchant = auth()->user(); 

        if (!$merchant) {
            abort(404, 'Merchant not found.');
        }

       
        $menus = $merchant->menus;

        return view('merchant.dashboard', compact('merchant', 'menus'));
    }

    public function createMenu()
    {
        return view('merchant.create-menu');
    }
    public function orderList()
    {
     
        $merchant = auth()->user();
      
        $orders = Order::whereHas('menu', function ($query) use ($merchant) {
            $query->where('merchant_id', $merchant->id);
        })->get();

        return view('merchant.orders', compact('orders'));
    }

    public function orderDetails(Order $order)
    {

        if (is_null($order->menu)) {
            dd('Menu not found', $order);
        }

        if ($order->menu->merchant_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }


        return view('merchant.order-details', compact('order'));


    }
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image',
            'price' => 'required|numeric',
        ]);

        $menu = new Menu($request->all());
        $menu->merchant_id = auth()->id();
        $menu->photo = $request->file('photo')->store('menu_photos', 'public');
        $menu->save();

        return redirect()->route('merchant.dashboard')->with('success', 'Menu added successfully.');
    }

    public function editProfile()
    {
        $merchant = Auth::user();

        return view('merchant.edit-profile', compact('merchant'));
    }

    public function updateProfile(Request $request)
    {
        $merchant = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $merchant->id,
            'alamat' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            
        ]);

        $merchant->name = $request->input('name');
        $merchant->email = $request->input('email');
        $merchant->alamat = $request->input('alamat');
        $merchant->kontak = $request->input('kontak');
        $merchant->deskripsi = $request->input('deskripsi');

        

        $merchant->save();

        return redirect()->route('merchant.edit-profile')->with('success', 'Profile updated successfully.');
    }

    public function editMenu(Menu $menu)
    {
        $this->authorize('update', $menu);
        return view('merchant.edit-menu', compact('menu'));
    }

    public function updateMenu(Request $request, Menu $menu)
    {
        $this->authorize('update', $menu);
        $menu->update($request->only('name', 'description', 'price'));
        if ($request->hasFile('photo')) {
            $menu->photo = $request->file('photo')->store('menu_photos', 'public');
        }
        return redirect()->route('merchant.dashboard')->with('success', 'Menu updated successfully.');
    }

    public function deleteMenu(Menu $menu)
    {
        $this->authorize('delete', $menu);
        $menu->delete();
        return redirect()->route('merchant.dashboard')->with('success', 'Menu deleted successfully.');
    }
}
