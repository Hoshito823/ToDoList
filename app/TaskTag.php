<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTag extends Model
{
    public static $rules = array(
        'tag_id' => 'required',
        'task_id' => 'required',
    );
}
