<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Media;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class UploadController extends Controller
{
    public function __construct(
        private readonly UploadService $service
    ) {
    }

    public function __invoke(UploadRequest $request): RedirectResponse
    {
        Gate::authorize('upload-files');

        $file = $this->service->avatar(
            $request->file('file')
        );

        Media::query()->create(
            $file->toArray()
        );

        return redirect()->back();
    }
}
