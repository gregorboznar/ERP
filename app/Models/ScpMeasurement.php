<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScpMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime',
        'user_id',
        'series_id',
        'product_id',
        'piece_id'
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function measurementFields(): HasMany
    {
        return $this->hasMany(ScpMeasurementField::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function series()
    {
        return $this->belongsTo(SeriesTender::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scpMeasurementFields()
    {
        return $this->hasMany(ScpMeasurementField::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }
}
