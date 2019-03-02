<?php

namespace App;

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
        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->surname = $request->surname;
        $new_user->phone = $request->phone;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        if($new_user->save())
            return json_encode('OK');
        return json_encode('NOT OK');
    }

    public static function checkUser(Request $request){
        if(User::where('email', '=', $request->email)->where('password', '=', $request->password)->count() == 1)
            return json_encode('OK');
        return json_encode('NOT OK');
    }
}
