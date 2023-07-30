<?php

namespace App\Actions\Fortify;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'jenis_kel' => ['required'],
            'kelas_id' => ['required'],
            'semester' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nim' => ['required', 'numeric', 'min:8', 'unique:mahasiswa'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();


        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'username' => $input['nim'],
                'path_image' => 'default.jpg',
                'role_id' => 2
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'name' => $input['name'],
                'nim' => $input['nim'],
                'kelas_id' => $input['kelas_id'],
                'semester' => $input['semester'],
                'tgl_lahir' => Date('Y-m-d'),
                'jenis_kel' => $input['jenis_kel']
            ]);

            DB::commit();

            Session::flash('message', 'Profil berhasil diperbarui');
            Session::flash('success', true);

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
