<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelled extends Model
{
    use HasFactory;

    protected $fillable = ['po_ID','cancelled_date','cancelled_qty','insert_by'];
}
