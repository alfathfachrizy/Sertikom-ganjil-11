<?php

namespace App\Policies;

use App\Models\SchoolSubmission;
use App\Models\User;

class SchoolSubmissionPolicy
{
    public function view(User $user, SchoolSubmission $submission): bool
    {
        return $user->isAdmin()
            || $submission->order()->where('user_id', $user->id)->exists();
    }
}
