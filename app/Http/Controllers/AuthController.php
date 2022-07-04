<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        if ($this->request->method() === 'POST') {
            $credentials = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password')
            ];
            if ($this->isAuth($credentials)) {
                return redirect('/dashboard');
            }
            return redirect()->back()->with('failed', 'Periksa Kembali Username dan Password Anda');
        }
        return view('admin.login');
    }

    public function login_member()
    {
        if ($this->request->method() === 'POST') {
            $credentials = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password')
            ];
            if ($this->isAuth($credentials)) {
                return redirect('/');
            }
            return redirect()->back()->with('failed', 'Periksa Kembali Username dan Password Anda');
        }
        return view('member.login');
    }

    public function register()
    {
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $user_data = [
                    'username' => $this->postField('username'),
                    'password' => Hash::make($this->postField('password')),
                    'role' => 'member'
                ];
                $user = $this->insert(User::class, $user_data);
                $member_data = [
                    'user_id' => $user->id,
                    'nama' => $this->postField('nama'),
                    'no_hp' => $this->postField('no_hp'),
                    'alamat' => $this->postField('alamat')
                ];
                $this->insert(Member::class, $member_data);
                DB::commit();
                Auth::loginUsingId($user->id);
                return redirect('/');
            }catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Lengkapi Data Anda Dengan Benar');
            }
        }
        return view('member.register');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
