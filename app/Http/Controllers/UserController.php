<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function UserDashboard()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('index',['userData' => $userData]);
    } //End Method

    public function UserProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = \Str::slug(date('YmHi').$request->name).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();
        $notification = array(
            'message'       => 'Perfil atualizado com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    } //End Method

    public function UserUpdatePassword(Request $request)
    {
        $validateData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        if (Hash::check($request->old_password,Auth::user()->password)) {
            User::whereId(Auth::user()->id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->back()->with("status", "Senha atualizada com sucesso");
        }else{
            return redirect()->back()->with("error", "A senha antiga não está correta");
        }

    } //End Method

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array(
            'message'       => 'Usuário deslogado com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect('/login')->with($notification);
    } //End Method
}
