<?php

namespace Edgewizz\Edgecontent\Models;
use Illuminate\Database\Eloquent\Model;

class DifficultyLevel extends Model{

    protected $table = 'difficulty_levels';
    protected $fillable = ['name', 'score'];
}
