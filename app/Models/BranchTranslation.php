<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'branch_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
