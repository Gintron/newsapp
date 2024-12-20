<?php

namespace App\Services\Account;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PreferenceService
{
    public function setPreferences(User $user, array $preferences)
    {
        $user->preferences = $preferences;
        $user->save();

        Cache::flush();
    }
}