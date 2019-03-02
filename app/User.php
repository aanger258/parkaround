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
        'name', 'surname', 'email', 'phone', 'password',
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
            'surname' => 'required',
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
        $new_user->surname = $request->surname;
        $new_user->phone = $request->phone;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        if($new_user->save())
            return $new_user->id;
        return "false";
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

        if(User::where('email', '=', $request->email)->where('password', '=', $request->password)->count() == 1)
            return User::where('email', '=', $request->email)->where('password', '=', $request->password)->first()->id);
        return "false";
    }
}
