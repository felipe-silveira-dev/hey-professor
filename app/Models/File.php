<?php

namespace App\Models;

class File
{
    public function __construct(
        public readonly string $name,
        public readonly string $originalName,
        public readonly string $mime,
        public readonly string $path,
        public readonly string $disk,
        public readonly string $hash,
        public readonly null|string $collection = null,
        public readonly int $size = 0,
    ) {
    }

    public function toArray(): mixed
    {
        return [
            'name'       => $this->name,
            'file_name'  => $this->originalName,
            'mime_type'  => $this->mime,
            'path'       => $this->path,
            'disk'       => $this->disk,
            'file_hash'  => $this->hash,
            'collection' => $this->collection,
            'size'       => $this->size,
        ];
    }
}
