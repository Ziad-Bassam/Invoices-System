<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function section()
    {
        return $this->belongsTo('App\models\section');
    }
}
