<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    protected $fillable = [
        'order_no',
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'country',
        'city',
        'district',
        'zip_code',
        'note',
        'status'
    ];


    public function orders() {
        return $this->hasMany(Order::class,'order_no','order_no');
    }
}
