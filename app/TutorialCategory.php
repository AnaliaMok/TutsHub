<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TutorialCategory extends Model
{
    use Searchable;
}
