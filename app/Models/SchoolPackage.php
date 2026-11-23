<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_per_participant',
        'min_participants',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_participant' => 'decimal:2',
            'min_participants' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    //
}
