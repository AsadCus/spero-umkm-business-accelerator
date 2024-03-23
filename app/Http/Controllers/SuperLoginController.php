<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Session;

class SuperLoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('pages-umkm.auth-login');
    }

    public function submitLogin(Request $request)
    {
        // dd('test');
        // if (Auth::check()) {
        //     return redirect()->route('set-level');
        // }
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if ($this->guard()->attempt($credentials)) {
                $request->session()->regenerate();

                // dd()
                if ($this->guard()->user()->id_role == 2 or $this->guard()->user()->id_role == 3 or $this->guard()->user()->id_role == 4) {
                    $request->session()->put('name', $this->guard()->user()->name);
                    $request->session()->put('id_user', $this->guard()->user()->id);
                    $request->session()->put('id_role', $this->guard()->user()->id_role);

                    if($this->guard()->user()->id_role == 2){
                        return redirect()->route('/dashboard');
                    }else if ($this->guard()->user()->id_role == 4 or $this->guard()->user()->id_role == 3) {
                        return redirect()->route('/umkm-unverif');
                    }else{
                        return redirect()->route('/list-materi');
                    }
                }else{
                    return redirect('login');
                }

            }
        } catch (\Throwable $th) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda.',
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Session::flush();
        // $this->guard()->logout();
        return redirect('login');

    }
}
