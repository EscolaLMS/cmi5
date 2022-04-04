<?php

namespace EscolaLms\Cmi5\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cmi5 extends Model
{
    protected $guarded = ['id'];

    public function aus(): HasMany
    {
        return $this->hasMany(Cmi5Au::class);
    }
}
