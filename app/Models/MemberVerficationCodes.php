<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberVerficationCodes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_verfication_codes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'member_id',
        'email',
        'code',
        'type',
        'action_type',
        'expires_at',
        'verified_at',
        'attempts',
        'created_at',
        'updated_at',
    ];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::creating(function ($verificationCode) {
            $verificationCode->expires_at = now()->addMinutes(5);
        });
    }
    /**
     * Get the user that owns the verification code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
