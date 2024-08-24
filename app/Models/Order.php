<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
        'delivery_address',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Relasi dengan model User (Customer)
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class); // Relasi dengan model Menu
    }
}
