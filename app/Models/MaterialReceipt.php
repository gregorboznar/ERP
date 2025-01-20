<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialReceipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'delivery_date',
        'delivery_note_number',
        'batch_number',
        'weight',
        'total',
        'user_id',
        'material_id',

    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
