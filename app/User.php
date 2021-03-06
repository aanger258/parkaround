<?php

namespace App;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function addNewUser(Request $request){
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $validator->after(function ($validator) {
            if (User::verifyEmail($validator->attributes())) {
                $validator->errors()->add('email', 'Email already in use!');
            }
            if (User::verifyPhone($validator->attributes())) {
                $validator->errors()->add('phone', 'Phone already in use!');
            }
        });

        if($validator->fails()) {
            return json_encode($validator->errors());
        }
        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->phone = $request->phone;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        if($new_user->save()){
            $array = [];
            $array['id'] = $new_user->id;
            $array['name'] = $new_user->name;
            return json_encode($array);
        }
        return json_encode(false);
    }

    public static function verifyEmail($data){
        if(isset($data['email']) && User::where('email', '=', $data['email'])->count() != 0)
            return true;
        return false;
    }
        public static function verifyPhone($data){
        if(isset($data['phone']) && User::where('phone', '=', $data['phone'])->count() != 0)
            return true;
        return false;
    }

    public static function checkUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return json_encode($validator->errors());
        }
        $user = User::where('email', '=', $request->email)->first();
        if(User::where('email', '=', $request->email)->count() == 1 && Hash::check($request->password, $user->password)){
            $array = [];
            $array['id'] = $user->id;
            $array['name'] = $user->name;
            return json_encode($array);
        }
        return json_encode(false);
    }
}
