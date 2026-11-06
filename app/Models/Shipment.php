<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'denomination',
        'currency_series',
        'yearmark',
        'supplier_name',
        'delivery_reference',
        'total_boxes',
        'total_notes',
        'first_box_code',
        'last_box_code',
        'documents_received_date',
        'delivery_date',
    ];

    protected function casts(): array
    {
        return [
            'documents_received_date' => 'date:Y-m-d',
            'delivery_date' => 'date:Y-m-d',
            'total_boxes' => 'integer',
            'total_notes' => 'integer',
        ];
    }
}
