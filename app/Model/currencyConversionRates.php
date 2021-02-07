<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class currencyConversionRates extends Model
{
    protected $fillable =['id', 'Official_sale_price', 'Official_purchase_price', 'informal_sale_price', 'informal_purchase_price', 'from_currency_id', 'to_currency_id', 'created_at', 'updated_at'];
}
