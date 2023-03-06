<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImg;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all',['products' => $products]);
    } //End Method

    public function AddProduct()
    {
        $activeVendor   = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        $brands         = Brand::latest()->get();
        $categories     = Category::latest()->get();
        $data['activeVendor']   = $activeVendor;
        $data['brands']         = $brands;
        $data['categories']     = $categories;
        return view('backend.product.product_add', $data);
    } //End Method

    public function StoreProduct(Request $request)
    {
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;
        
        $product_id = Product::insertGetId([
            'brand_id'          => $request->brand_id,
            'category_id'       => $request->category_id,
            'subcategory_id'    => $request->subcategory_id,
            'product_name'      => $request->product_name,
            'product_slug'          => strtolower(str_replace(' ','-',$request->product_name)),
            'product_code'      => $request->product_code,
            'product_qty'       => $request->product_qty,
            'product_tags'      => $request->product_tags,
            'product_size'      => $request->product_size,
            'product_color'     => $request->product_color,
            'selling_price'     => $request->selling_price,
            'discount_price'    => $request->discount_price,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'product_thambnail' => $save_url,
            'vendor_id'         => $request->vendor_id,
            'hot_deals'         => $request->hot_deals,
            'featured'          => $request->featured,
            'especial_offer'    => $request->especial_offer,
            'especial_deals'    => $request->especial_deals,
            'status'            => 1,
            'created_at'        => Carbon::now(),
        ]);
        ///Multiplas imagens aqui///
        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uplodPath = 'upload/products/multi-image/'.$make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $uplodPath,
                'created_at' => Carbon::now(),
            ]); //End foreach
        } //End mult_img

        $notification = array(
            'message'       => 'Produto inserido com sucesso.',
            'alert-type'    => 'success'
        );
        return redirect()->route('all.product')->with($notification);

    } //End Method
}
