<?php

namespace App\User\Infrastructure\Persistence\Eloquent;

use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use App\Vote\Infrastructure\Persistence\Eloquent\VoteModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Creates a new factory for this model
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * The votes that belong to the UserModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votesGiven(): HasMany
    {
        return $this->hasMany(VoteModel::class, 'user_id');
    }

    /**
     * The votes that belong to the UserModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votedSellers(): BelongsToMany
    {
        return $this->belongsToMany(SellerModel::class, 'votes', 'user_id', 'seller_id');
    }
}
