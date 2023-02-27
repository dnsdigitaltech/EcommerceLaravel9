<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class VendorController extends Controller
{
    public function VendorDashboard()
    {
        return view('vendor.index');
    } //End Method

    public function VendorLogin()
    {
        return view('vendor.vendor_login');
    } //End Method

    public function VendorProfile()
    {
        $id = Auth::user()->id;
        $vendorData = User::find($id);
        return view('vendor.vendor_profile_view',['vendorData' => $vendorData]);
    } //End Method

    public function VendorProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id );
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_join = $request->vendor_join;
        $data->vendor_short_info = $request->vendor_short_info;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/vendor_images/'.$data->photo));
            $filename = \Str::slug(date('YmHi').$request->name).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/vendor_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();
        $notification = array(
            'message'       => 'Perfil atualizado com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    } //End Method

    public function VendorChangePassword()
    {
        $id = Auth::user()->id;
        $vendorData = User::find($id);
        return view('vendor.vendor_change_password',['vendorData' => $vendorData]);
    } //End Method

    public function VendorUpdatePassword(Request $request)
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

    public function VendorDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/fornecedor/login');
    } //End Method

    public function BecomeVendor()
    {
        return view('auth.become_vendor');
    } //End Method

    public function VendorRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'vendor_join' => $request->vendor_join,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',
        ]);      
        $notification = array(
            'message'       => 'Fornecerdor Registrado com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('vendor.login')->with($notification);          
    } //End Method
}
