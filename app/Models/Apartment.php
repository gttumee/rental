<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'number_of_rooms',
        'status',
        'repair_date',
        'rent_price',
        'other_info',
        'user_id',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    
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

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}