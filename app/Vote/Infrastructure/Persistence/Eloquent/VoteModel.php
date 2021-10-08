<?php

namespace App\Vote\Infrastructure\Persistence\Eloquent;

use App\Contest\Infrastructure\Persistence\Eloquent\ContestModel;
use App\Seller\Domain\Seller;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use App\User\Infrastructure\Persistence\Eloquent\UserModel;
use App\Vote\Application\Events\VoteHasBeenCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteModel extends Model
{
    use HasFactory;

    protected $table = "votes";

    protected $dispatchesEvents = [
        'created' => VoteHasBeenCreated::class,
    ];

    protected static function newFactory()
    {
        return VoteFactory::new();
    }

    /**
     * Get the contest that owns the VoteModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contest(): BelongsTo
    {
        return $this->belongsTo(ContestModel::class, 'contest_id');
    }

    /**
     * Get the user that owns the VoteModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    /**
     * Get the seller that owns the VoteModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(SellerModel::class, 'seller_id');
    }

    public function scopeByContestId(Builder $query, int $id): Builder
    {
        return $query->where('contest_id', $id);
    }

    public function scopeBySellerId(Builder $query, int $id): Builder
    {
        return $query->where('seller_id', $id);
    }

    public function scopeByUserId(Builder $query, int $id): Builder
    {
        return $query->where('seller_id', $id);
    }
}
