<?php

namespace App\Actions;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadAvatar
{
    public function handle(UploadedFile $file): File
    {
        $name = $file->hashName();

        $path = Storage::put("avatars", $file);
        $path = (string) $path;

        return new File(
            $name,
            $file->getClientOriginalName(),
            $file->getClientMimeType(),
            $path,
            'local',
            $file->hashName(),
            'avatars',
            $file->getSize(),
        );
    }
}
