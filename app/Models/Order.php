<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	protected $table = 'orders';
    
    protected $fillable = ['order', 'driver','client','region', 'car'];

}
