<?php

namespace App\Services;

use App\Models\User;

class UserService {

    public function getUser($id): User {
        return User::find($id);
    }

    public function paginateUsers()
    {
        return User::paginate(5);
    }

    public function createUser($data): User {
        $newUser = new User([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'date_of_birth' => $data['date_of_birth'],
        ]);

        $newUser->save();
        return $newUser->fresh();
    }
}
