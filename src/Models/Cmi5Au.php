<?php

namespace EscolaLms\Cmi5\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cmi5Au extends Model
{
    protected $guarded = ['id'];

    public function cmi5(): BelongsTo
    {
        return $this->belongsTo(Cmi5::class);
    }
}
