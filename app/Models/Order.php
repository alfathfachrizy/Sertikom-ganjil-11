<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public const STATUS_PENDING_APPROVAL = 'pending_approval';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_AWAITING_PAYMENT = 'awaiting_payment';

    public const STATUS_PAID = 'paid';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_EXPIRED = 'expired';

    public const TYPE_GENERAL = 'general';

    public const TYPE_SCHOOL = 'school';

    protected $fillable = [
        'user_id',
        'order_code',
        'order_type',
        'visit_date',
        'total_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function schoolSubmission(): HasOne
    {
        return $this->hasOne(SchoolSubmission::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function eTicket(): HasOne
    {
        return $this->hasOne(ETicket::class);
    }
    //
}
