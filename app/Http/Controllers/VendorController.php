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

    public function VendorDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    } //End Method
}
