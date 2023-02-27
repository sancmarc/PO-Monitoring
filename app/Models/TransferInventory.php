<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferInventory extends Model
{
    use HasFactory;
    protected $fillabel =['billed_id', 'date_delivery', 'out_delivered'];
}
