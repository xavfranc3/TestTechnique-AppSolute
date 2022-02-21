<?php

namespace App\Services;

use App\Models\ApiUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiUserService {

    public function createApiUser($apiUserData): ApiUser {
        $hashedPassword = $this->hashPassword($apiUserData);
        $newApiUser = new ApiUser([
            'user_name' => $apiUserData['user_name'],
            'password' => $hashedPassword
        ]);
        $newApiUser->save();
        return $newApiUser->fresh();
    }

    private function hashPassword($apiUserData): string {
        return Hash::make($apiUserData['password']);
    }

    public function authenticateApiUser($apiUserData): bool
    {
        $apiUser = ApiUser::where('user_name', $apiUserData['user_name'])->first();
        print_r($apiUser);
        return Hash::check($apiUserData['password'], $apiUser->password);
    }
}
