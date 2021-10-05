<?php

namespace App\Contest\Infrastructure\Persistence\Eloquent;

use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contests';

    protected $fillable = ['name', 'status'];

    /**
     * The sellers that belong to the ContestModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sellers(): BelongsToMany
    {
        return $this->belongsToMany(SellerModel::class, 'votes', 'contest_id', 'seller_id');
    }
}
