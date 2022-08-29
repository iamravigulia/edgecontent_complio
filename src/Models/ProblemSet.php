<?php

namespace Edgewizz\Edgecontent\Models;
use Illuminate\Database\Eloquent\Model;

class ProblemSet extends Model{

    protected $table = 'problem_sets';
    
    public function formats(){
        return $this->belongsToMany('Edgewizz\Edgecontent\Models\FormatType');
    }
    public function questions(){
        return $this->hasMany('Edgewizz\Edgecontent\Models\ProblemSetQues');
    }
}
