<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Image;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('backend.category.category_all',['categories' => $categories]);
    } //End Method

    public function AddCategory()
    {
        return view('backend.category.category_add');
    } //End Method

    public function StoreCategory(Request $request)
    {

        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(120,120)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
            'category_image' => $save_url,
        ]);

        $notification = array(
            'message'       => 'Categoria inserida com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('all.category')->with($notification);
    } //End Method
    public function EditBrand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.brand_edit',['brand' => $brand]);
    } //End Method
    public function UpdateBrand(Request $request)
    {
        $brand_id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('brand_image')) {
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
            $save_url = 'upload/brand/'.$name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
                'brand_image' => $save_url,
            ]);

            $notification = array(
                'message'       => 'Marca com imagem atualizada com sucesso.',
                'alert-type'    => 'success'
            );
            return redirect()->route('all.brand')->with($notification);
        }else{
            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),                
            ]);

            $notification = array(
                'message'       => 'Marca sem imagem atualizada com sucesso.',
                'alert-type'    => 'success'
            );
            return redirect()->route('all.brand')->with($notification);
        }//end else
    } //End Method
}
