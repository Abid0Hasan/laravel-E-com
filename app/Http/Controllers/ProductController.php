<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{

    public function index(Category $category)
    {
        return response()->json(Product::with(['categories'])->get(),200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'detail' => 'required',
            'price' => 'required',
            'stock' => 'required|integer',
            'discount' => 'required',

        ]);
        $get_last_product_insert_id = DB::table('products')->insertGetId([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'detail' => $request->detail,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
            'created_at' => Carbon::now(),
        ]);
        if ($request->product_image) {

            $exploed1 = explode(";", $request->product_image);
            $exploed2 = explode("/", $exploed1[0]);
            $filename = time() . '.' . $exploed2[1];

            Image::make($request->product_image)->save(base_path('public/uploads/product_images/' . $filename), 50);
            DB::table('products')->where('id', $get_last_product_insert_id)->update([
                'product_image' => $filename,
            ]);
        }
    }

    public function show( $id)
    {
        return Product::findOrfail($id);
    }

    public function cat_pro_show(Category $category,Product $product)
    {
        return Product::findOrfail($product);
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'detail'=>'required',
            'price'=>'required',
            'stock'=>'required|integer',
            'discount'=>'required',
        ]);

        DB::table('products')->where('id',$id)->update([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'detail'=>$request->detail,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'discount'=>$request->discount,
        ]);

        if ($request->product_image) {

            $product =  Product::find($id);

            if($product->product_image =='default_img.jpg'){

                $exploed1 = explode(";", $request->product_image);
                $exploed2 = explode("/", $exploed1[0]);
                $filename =  time().'.'.$exploed2[1];

                Image::make($request->product_image)->save(base_path('public/uploads/product_images/'.$filename));
                DB::table('products')->where('id',$id)->update([
                    'product_image'=>$filename,
                ]);

            }else {
                unlink(base_path('public/uploads/product_images/'.$product->product_image));

                $exploed1 = explode(";", $request->product_image);
                $exploed2 = explode("/", $exploed1[0]);
                $filename =  time().'.'.$exploed2[1];

                Image::make($request->product_image)->save(base_path('public/uploads/product_images/'.$filename),50);
                DB::table('products')->where('id',$id)->update([
                    'product_image'=>$filename,
                ]);
            }


        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =  Product::find($id);
        if($product->product_image =='default_img.jpg'){
            Product::find($id)->delete();
        }else{

            Product::find($id)->delete();
            unlink(base_path('public/uploads/product_images/'.$product->product_image));
        }

    }
}
