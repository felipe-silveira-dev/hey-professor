<?php

use App\Models\User;

function user(): ?User
{
    if(!auth()->check()) {
        return null;
    }

    return auth()->user();
}
