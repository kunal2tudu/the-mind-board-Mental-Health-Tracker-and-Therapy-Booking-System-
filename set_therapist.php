<?php
$user = App\Models\User::first();
if ($user) {
    $user->is_therapist = true;
    $user->linked_therapist_id = '1';
    $user->save();
    echo "Success! User '{$user->name}' is now a therapist.";
} else {
    echo "No users found in database.";
}
