<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    } //End Method

    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_change_password',['adminData' => $adminData]);
    } //End Method

    public function AdminUpdatePassword(Request $request)
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

    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } //End Method

    public function InactiveVendor(){
        $inActiveVendor = User::where('status','inactive')->where('role','vendor')->latest()->get();
        return view('backend.vendor.inactive_vendor', ['inActiveVendor' => $inActiveVendor]);
    } //End Method

    public function ActiveVendor(){
        $activeVendor = User::where('status','active')->where('role','vendor')->latest()->get();
        return view('backend.vendor.active_vendor', ['activeVendor' => $activeVendor]);
    } //End Method

    public function InactiveVendorDetails($id) {
        $inActiveVendorDetails = User::findOrFail($id);
        return view('backend.vendor.inactive_vendor_details', ['inActiveVendorDetails' => $inActiveVendorDetails]);
    } //End Method

    public function ActiveVendorApprove(Request $request){
        $vendor_id = $request->id;
        $user = User::findOrFail($vendor_id)->update([
            'status' => 'active',
        ]);
        $notification = array(
            'message'       => 'Fornecerdor ativo com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('active.vendor')->with($notification); 
    } //End Method

    public function ActiveVendorDetails($id) {
        $activeVendorDetails = User::findOrFail($id);
        return view('backend.vendor.active_vendor_details', ['activeVendorDetails' => $activeVendorDetails]);
    } //End Method

    public function InactiveVendorApprove(Request $request){
        $vendor_id = $request->id;
        $user = User::findOrFail($vendor_id)->update([
            'status' => 'inactive',
        ]);
        $notification = array(
            'message'       => 'Fornecerdor inativo com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('inactive.vendor')->with($notification); 
    } //End Method
}
