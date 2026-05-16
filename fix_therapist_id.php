<?php
$user = App\Models\User::first();
$therapist = App\Models\Therapist::first();
if ($user && $therapist) {
    $user->is_therapist = true;
    $user->linked_therapist_id = $therapist->_id;
    $user->save();
    echo "Success! User '{$user->name}' is linked to actual therapist ID: '{$therapist->_id}'.";
} else {
    echo "No users or therapists found in database.";
}
