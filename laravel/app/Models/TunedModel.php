<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TunedModel extends Model
{
    use HasFactory;
    protected $table = 'tuned_models';
    protected $guarded = ['id'];

}
