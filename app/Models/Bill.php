<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'recipient_phone',
        'recipient_address',
        'total_amount',
        'status',
        'pay',
        'voucher'
    ];

    protected $table = 'bills';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function billStory()
    {
        return $this->hasMany(BillStory::class);
    }
}