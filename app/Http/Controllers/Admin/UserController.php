<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Tampilkan halaman kelola pengguna
     */
    public function index()
    {
        // pagination 10 data per halaman
        $users = User::orderBy('id','desc')
                    ->paginate(10);

        return view(
            'admin.kelolapengguna',
            compact('users')
        );
    }



    /**
     * Simpan user baru (dibuat admin)
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'nama' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'username'=>[
                    'required',
                    'min:5',
                    'max:20',
                    'unique:users,username'
                ],

                'email'=>[
                    'required',
                    'email',
                    'unique:users,email'
                ],

                'password'=>[
                    'required',
                    'min:6'
                ],

                'role'=>[
                    'required',
                    'in:mahasiswa,dosen,staf,operator,admin'
                ],

            ],
            [

                'nama.required'=>'Nama wajib diisi',

                'username.required'=>'Username wajib diisi',
                'username.unique'=>'Username sudah terdaftar',

                'email.unique'=>'Email sudah terdaftar',

                'password.min'=>'Password minimal 6 karakter',

                'role.in'=>'Role tidak valid',
            ]
        );


        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        User::create([

            'nama'=>$request->nama,

            // kompatibel jika ada kolom name
            'name'=>$request->nama,

            'username'=>$request->username,
            'email'=>$request->email,

            'password'=>Hash::make(
                $request->password
            ),

            'role'=>$request->role,

        ]);


        return redirect()
            ->route('admin.kelolapengguna')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan'
            );
    }




    /**
     * Update user
     */
    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);


        $validator = Validator::make(
            $request->all(),
            [

                'nama'=>[
                    'required',
                    'string',
                    'max:255'
                ],

                'username'=>[
                    'required',
                    'min:5',
                    'max:20',
                    'unique:users,username,'.$id
                ],

                'email'=>[
                    'required',
                    'email',
                    'unique:users,email,'.$id
                ],

                'password'=>[
                    'nullable',
                    'min:6'
                ],

                'role'=>[
                    'required',
                    'in:mahasiswa,dosen,staf,operator,admin'
                ],

            ],
            [

                'nama.required'=>'Nama wajib diisi',

                'username.unique'=>
                    'Username sudah digunakan',

                'email.unique'=>
                    'Email sudah digunakan',

                'password.min'=>
                    'Password minimal 6 karakter',
            ]
        );


        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }



        $updateData = [

            'nama'=>$request->nama,
            'name'=>$request->nama,

            'username'=>$request->username,
            'email'=>$request->email,

            'role'=>$request->role
        ];


        // ubah password jika diisi
        if($request->filled('password')){
            $updateData['password']=
                Hash::make(
                    $request->password
                );
        }


        $user->update($updateData);



        return redirect()
            ->route('admin.kelolapengguna')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui'
            );
    }




    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);


        // cegah hapus akun sendiri
        if(auth()->id()==$id){
            return back()->with(
                'error',
                'Tidak bisa menghapus akun sendiri'
            );
        }


        $user->delete();


        return back()->with(
            'success',
            'Pengguna berhasil dihapus'
        );
    }
}