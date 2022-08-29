<?php

namespace Edgewizz\Edgecontent\Models;
use Illuminate\Database\Eloquent\Model;

class FormatType extends Model{

    protected $table = 'format_types';
    protected $fillable = ['name', 'slug','question_table_name','answer_table_name'];
}
