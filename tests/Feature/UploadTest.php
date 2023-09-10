<?php

use App\Http\Controllers\UploadController;
use App\Models\{Media, User};
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

test('can upload an avatar', function () {
    Storage::fake('avatars');

    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('avatar.png');
    //act
    actingAs($user);

    post(
        action(UploadController::class),
        [
            'file' => $file,
        ]
    )->assertRedirect();

    assertDatabaseHas('media', [
        'name'       => $file->hashName(),
        'file_name'  => $file->getClientOriginalName(),
        'mime_type'  => $file->getClientMimeType(),
        'path'       => 'avatars/' . $file->hashName(),
        'disk'       => 'local',
        'collection' => 'avatars',
        'size'       => $file->getSize(),
    ]);

    Storage::disk('local')->assertExists('avatars/' . $file->hashName());
});
