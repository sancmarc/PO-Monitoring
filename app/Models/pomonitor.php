<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pomonitor extends Model
{
    use HasFactory;
    protected $fillable = ['received_date','model','p_n','po_no','unit_price','po_qty'];
}
