<?php

namespace App\Services;

use App\Actions\UploadAvatar;
use App\Models\File;
use Illuminate\Http\UploadedFile;

class UploadService
{
    public function __construct(
        private readonly UploadAvatar $avatar
    ) {
    }
    public function avatar(UploadedFile $file): File
    {
        return $this->avatar->handle($file);
    }
}
