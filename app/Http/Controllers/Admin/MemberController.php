<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Member::with('user')->get();
        return view('admin.pengguna.member.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        return view('admin.pengguna.member.add');
    }

    public function create()
    {
        try {
            DB::beginTransaction();
            $user_data = [
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'role' => 'member',
            ];
            $user = User::create($user_data);
            $member_data = [
                'user_id' => $user->id,
                'nama' => $this->postField('nama'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat')
            ];
            Member::create($member_data);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = User::with('member')->where('id', '=', $id)->firstOrFail();
        return view('admin.pengguna.member.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            DB::beginTransaction();
            $id = $this->postField('id');
            $user = User::find($id);
            $data_user = [
                'username' => $this->postField('username'),
            ];

            if ($this->postField('password') !== '') {
                $data_user['password'] = Hash::make($this->postField('password'));
            }
            $user->update($data_user);
            $member = Member::with('user')->where('user_id', '=', $user->id)->firstOrFail();
            $member_data = [
                'nama' => $this->postField('nama'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat')
            ];
            $member->update($member_data);
            DB::commit();
            return redirect('/member')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();
            $id = $this->postField('id');
            Member::with('user')->where('user_id', '=', $id)->delete();
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }
}
