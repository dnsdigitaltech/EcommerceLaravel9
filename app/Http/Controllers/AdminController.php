<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    } //End Method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    } //End Method

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',['adminData' => $adminData]);
    } //End Method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id );
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = \Str::slug(date('YmHi').$request->name).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();
        $notification = array(
            'message'       => 'Perfil atualizado com sucesso.',
            'alert-type'    => 'info'
        );
        return redirect()->back()->with($notification);
    } //End Method

    public function ChangePassword()
    {
        return view('admin.admin_change_password');
    } //End Method

    public function UpdatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword,$hashedPassword)) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();
            session()->flash('message', 'Senha atualizada com sucesso');
            return redirect()->back();
        }else{
            session()->flash('message', 'A senha antiga não está correta');
            return redirect()->back();
        }

    } //End Method

    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } //End Method
}
