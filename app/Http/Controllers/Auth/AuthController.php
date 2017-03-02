<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $result = DB::select('select * from users where user_name = ?',[$data['user_name']]);

        if (!empty($result)){
            return false;
        }else{
            return DB::insert('insert into users (user_name, password) values (?, ?)', [$data['user_name'], bcrypt($data['password'])]);
        }
    }
    public function login(Request $request){
        if ($request->isMethod('POST')){
            if (Auth::attempt(['user_name' => $request->input('user_name'),'password' => $request->input('password'),'status' => 1])){
                return redirect()->route('list_social');
            }else{
                $validate_make = Validator::make(array(),array(),array());
                $validate_make->errors()->add('field', 'can not login ');
                return redirect()->route('login')->withErrors($validate_make);
            }
        }
        return view('admin.login');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function validateRegister(Request $request){

        $this->validate($request,['user_name'=>'required|max:255','password' => 'required|min:6','password_confirm' => 'required|same:password']);
        if ($this->create(array('user_name'=>$request->input('user_name'),'password' => $request->input('password')))){
            return redirect()->route('admin');
        }else{
            $validate_make = Validator::make(array(),array(),array());
            $validate_make->errors()->add('field', 'username : '.$request->input('user_name') .' was exist!');
            return redirect()->route('register')->withErrors($validate_make);
        }

    }
    public function register(Request $request){

        return view('admin.register');
    }


}
