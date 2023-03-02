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
}
