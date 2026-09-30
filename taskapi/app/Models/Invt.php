<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invt extends Model {

    protected $fillable = [
        'invt_part_no',
        'invt_uom',
        'invt_type'
    ]

}