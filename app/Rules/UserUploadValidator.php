<?php

namespace App\Rules;

use Illuminate\Validation\Rules\File;

class UserUploadValidator
{
    public function avatars(): mixed
    {
        return [
            'required',
            File::types(['png', 'jpg'])
                ->max(5 * 1024),
        ];
    }
}
