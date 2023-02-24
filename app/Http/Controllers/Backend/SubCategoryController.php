<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Image;

class SubCategoryController extends Controller
{
    public function AllSubCategory()
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all',['subcategories' => $subcategories]);
    } //End Method

    public function AddSubCategory()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view('backend.subcategory.subcategory_add',['categories' => $categories]);
    } //End Method

    public function StoreSubCategory(Request $request)
    {

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
        ]);

        $notification = array(
            'message'       => 'SubCategoria inserida com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('all.subcategory')->with($notification);
    } //End Method
    public function EditSubCategory($id)
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        $data['categories'] = $categories;
        $data['subcategory'] = $subcategory;
        return view('backend.subcategory.subcategory_edit',$data);
    } //End Method
    public function UpdateSubCategory(Request $request)
    {
        $subcategory_id = $request->id;
        SubCategory::findOrFail($subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),                
        ]);

        $notification = array(
            'message'       => 'SubCategoria atualizada com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('all.subcategory')->with($notification);
    } //End Method
    public function DeleteSubCategory($id)
    {
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message'       => 'SubCategoria removida com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }//End Method
}
