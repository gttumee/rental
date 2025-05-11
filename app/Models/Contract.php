<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = [
        'lastname',
        'firstname',
        'register_number',
        'phone_number',
        'phone_number_second',
        'other_info',
        'apartment_id',
        'user_id',
        'rent_amount',
        'deposit_amount',
        'late_fee_amount',
        'status',
        'payment_schedule',
        'register_number',
        'phone_number',
        'phone_number_second',
        'contract_other_info',
        'contract_start_date',
        'contract_end_date',
    ];
    
    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if ($user = auth()->user()) {
                $builder->whereHas('user', function ($query) use ($user) {
                    $query->where('company_id', $user->company_id);
                });
            }
        });
    }
      
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}