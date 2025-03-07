<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Active_code extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expired_at'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGenerateCode($query, $user)
    {
        if($code = $this->getActiveCodeForUser($user)) {
            $code->code;
        } else {
            do {
                $code = mt_rand(100000,999999);
            } while ($this->checkCodeIsUnique($user, $code));

            $user->activecode()->create([
                'code' => $code,
                'expired_at' => now()->addMinutes(10)
            ]);
        }

        return $code;
    }

    private function checkCodeIsUnique($user, int $code): bool
    {
        return !! $user->activecode()->whereCode($code)->first();
    }

    private function getActiveCodeForUser($user)
    {
        return $user->activecode()->where('expired_at','>',now())->first();
    }
}
