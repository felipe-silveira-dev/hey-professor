<?php

namespace App\Livewire;

use App\Models\Media;
use App\Rules\UserUploadValidator;
use App\Services\UploadService;
use Illuminate\Contracts\View\View;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\{Component, WithFileUploads};

final class UploadForm extends Component
{
    use WithFileUploads;

    public null|string|TemporaryUploadedFile $file = null;

    public function rules(): mixed
    {
        return (new UserUploadValidator())->avatars();
    }

    public function upload(UploadService $service): void
    {
        $this->validate();

        try {
            $file = $service->avatar(
                $this->file,
            );
        } catch (\Throwable $e) {
            throw $e;
        }

        /** @phpstan-ignore-next-line */
        Media::query()->create([
            $file->toArray(),
        ]);
    }

    public function render(): View
    {
        return view('livewire.upload-form');
    }
}
