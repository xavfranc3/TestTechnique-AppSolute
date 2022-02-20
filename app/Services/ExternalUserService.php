<?php

namespace App\Services;

use App\Models\User;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ExternalUserService
{
    public function createExternalUser(): User {
        $originalArray = $this->fetchRandomUser();
        $newUser = new User($this->extractUserValues($originalArray));
        $newUser->save();
        return $newUser->fresh();
    }


    public function fetchRandomUser() {
        return json_decode(Http::get('randomuser.me/api'), true);
    }

    public function extractUserValues ($originalArray): array
    {
        $userData = [];

        foreach ($originalArray as $dimension1Key => $dimension1Array) {
            if ($dimension1Key == 'results') {
                foreach ($dimension1Array as $dimension2Key => $dimension2Array) {
                    foreach ($dimension2Array as $dimension3Key => $dimension3Array) {
                        if ($dimension3Key == 'email') {
                            $userData['email'] = $dimension3Array;
                        }
                        if (is_array($dimension3Array) && $dimension3Key == 'name') {
                            foreach ($dimension3Array as $nameKey => $nameValue) {
                                if ($nameKey == 'first') {
                                    $userData['first_name'] = $nameValue;
                                }
                                if ($nameKey == 'last') {
                                    $userData['last_name'] = $nameValue;
                                }
                            }
                        }
                        if (is_array($dimension3Array) && $dimension3Key == 'dob') {
                            foreach ($dimension3Array as $dobKey => $dobValue) {
                                if ($dobKey == 'date') {
                                    // Transform dob.date string to a valid date
                                    $date_of_birth = new DateTime($dobValue);

                                    $userData['date_of_birth'] = $date_of_birth;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $userData;
    }



    public function createNewUserWithLaravelHelper(): User {
        $originalUserArray = $this->fetchRandomUser();
        $flattenedArray = Arr::dot($originalUserArray);
        $newUser = new User($this->extractNewUserValues($flattenedArray));
        $newUser->save();
        return $newUser->fresh();
    }

    public function extractNewUserValues($flattenedArray): array {
        $userData = [];
        $userFields = [
            'first_name' => 'results.0.name.first',
            'last_name' => 'results.0.name.last',
            'email' => 'results.0.email',
            'date_of_birth' => 'results.0.dob.date'
        ];
        $userFieldsKeys = array_keys($userFields);
        foreach ($userFieldsKeys as $userFieldsKey) {
            $userData[$userFieldsKey] = $flattenedArray[$userFields[$userFieldsKey]];
        }
        return $userData;
    }
}
