<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'description', 'photo', 'price', 'merchant_id'];
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
    use HasFactory;
}
