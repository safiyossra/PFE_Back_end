<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passager extends Model
{
    use HasFactory;
    protected $fillable=['id','lastName','FirstName','address','city','tel','cin','client','cood_gps','country','code'];
}
