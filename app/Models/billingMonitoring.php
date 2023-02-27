<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billingMonitoring extends Model
{
    use HasFactory;
    protected $fillable =['months','billInovoice','po_no','billQty'];
}
