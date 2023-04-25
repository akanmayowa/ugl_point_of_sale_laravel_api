<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CustomerType extends Model
{
    use HasFactory;
    public const Retail = 'retail';
    public const Dealer = 'dealer';
    public const Staff = 'staff';
    public const Crs = 'crs';
    protected $guarded = ['id'];
}
