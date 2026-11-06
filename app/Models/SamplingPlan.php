<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SamplingPlan extends Model
{
    protected $fillable = [
        'shipment_id',
        'standard_ref',
        'target_sample_boxes',
        'target_sample_bundles',
        'target_sample_notes',
        'bundles_per_box',
        'notes_per_bundle',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_sample_boxes' => 'integer',
            'target_sample_bundles' => 'integer',
            'target_sample_notes' => 'integer',
            'bundles_per_box' => 'integer',
            'notes_per_bundle' => 'integer',
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
