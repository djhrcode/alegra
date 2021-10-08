<?php

namespace App\Contest\Infrastructure\Persistence\Eloquent;

use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use App\Vote\Infrastructure\Persistence\Eloquent\VoteModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contests';

    protected $fillable = ['name', 'status', 'invoice_id'];

    /**
     * The sellers that belong to the ContestModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sellers(): BelongsToMany
    {
        return $this->belongsToMany(SellerModel::class, 'votes', 'contest_id', 'seller_id');
    }

    /**
     * The sellers that belong to the ContestModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(SellerModel::class, 'winner_id');
    }

    /**
     * Get all of the votes for the ContestModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(VoteModel::class, 'contest_id');
    }

    public function setWinner(string $winnerId): void
    {
        $this->winner()->associate($winnerId);
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setInvoiceId(int $invoiceId): void
    {
        $this->invoice_id = $invoiceId;
    }
}
