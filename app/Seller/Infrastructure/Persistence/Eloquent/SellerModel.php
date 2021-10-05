<?php

namespace App\Seller\Infrastructure\Persistence\Eloquent;

use App\Seller\Application\Events\SellerHasBeenCreated;
use App\Seller\Infrastructure\Persistence\Eloquent\Scopes\OnlySellerSynced;
use App\Vote\Infrastructure\Persistence\Eloquent\VoteModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    const ONLY_SYNCED_SCOPE = OnlySellerSynced::class;

    protected $table = 'sellers';

    protected $fillable = [
        'name',
        'alegra_id',
    ];

    protected $with = ['votes'];

    protected $dispatchesEvents = [
        'created' => SellerHasBeenCreated::class,
    ];

    protected static function newFactory()
    {
        return SellerFactory::new();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OnlySellerSynced);
    }

    /**
     * Get all of the votes for the SellerModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(VoteModel::class, 'seller_id');
    }

    public function countVotesOnActiveContest(): int
    {
        return $this->countVotesByContest(1);
    }

    public function countVotesByContest(int $id): int
    {
        return $this->votes()->byContestId($id)->count();
    }

    public function getAlegraId(): ?int
    {
        return $this->alegra_id;
    }
}
