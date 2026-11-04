<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    public const TYPES = [
        'Saree Enquiry', 'Lehenga Enquiry', 'Bridal Wear', 'Product Availability',
        'Order Assistance', 'Store Visit', 'General Enquiry',
    ];

    protected $fillable = ['name', 'phone', 'email', 'type', 'message', 'ip_address', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];
}