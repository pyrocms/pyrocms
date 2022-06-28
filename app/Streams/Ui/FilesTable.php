<?php

namespace App\Streams\Ui;

use Streams\Ui\Components\Table;
use Illuminate\Support\Facades\Request;

class FilesTable extends Table
{
    public function onQuerying()
    {
        if ($path = Request::get('path')) {
            $this->criteria->where('path', 'LIKE', $path . '%');
            $this->criteria->where('path', 'NOT LIKE', $path . '\/%');
        }
    }
}
