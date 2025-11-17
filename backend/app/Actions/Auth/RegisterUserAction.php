<?php

namespace App\Actions\Auth;

use App\Models\Users;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    /**
     * Handle user registration logic.
     * Assumes $data is already validated by a FormRequest.
     */
    public function handle(array $data): Users
    {
        $birthDate = new \DateTime($data['dob']);
        $today     = new \DateTime();
        $age       = $today->diff($birthDate)->y;

        $imagePath = null;
        if (isset($data['image'])) {
            $image     = $data['image']; // UploadedFile
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $imagePath = $image->storeAs('profile_images', $imageName, 'public');
        }
        $user = Users::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'full_name'     => $data['first_name'] . ' ' . $data['last_name'],
            'dob'           => $data['dob'],
            'age'           => $age,
            'gender'        => $data['gender'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'image' => $imagePath,
        ]);

        $userRole = Roles::where('slug', 'customer')->first();
        if ($userRole) {
            $user->roles()->attach($userRole->role_id);
        }

        return $user;
    }
}
