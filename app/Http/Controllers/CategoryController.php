<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryCollection;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResouce;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;



class CategoryController extends Controller
{

    public function index()
    {

        return CategoryResouce::collection(Category::with('products')->paginate(20));
       // return response()->json(Category::all(),200);
        //return CategoryResouce::collection(Category::paginate(5));
        //return Category::orderBy('id','desc')->get();
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // return $request->all();
        $validate = $request->validate([
            'category_name'=>'required|unique:categories,category_name',
            'category_description'=>'required',
            'publication_status'=>'required',
        ]);
        DB::table('categories')->insert([
            'category_name'=>$request->category_name,
            'category_description'=>$request->category_description,
            'publication_status'=>$request->publication_status,
            'created_at'=>Carbon::now(),
        ]);
    }


    public function show($id)
    {
        return Category::findOrFail($id);

//
//        public function show(Category $category)
//    {
//        $category->setRelation('products', $category->products()->paginate(10));
//        return $this->showOnePaginate($category, 200);
//    }



    }


    public function edit(Category $category)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            // 'category_name'=>'required|unique:categories,category_name',
            'category_name'=>'required',
            'category_description'=>'required',
            'publication_status'=>'required',
        ]);

        DB::table('categories')->where('id',$id)->update([
            'category_name'=>$request->category_name,
            'category_description'=>$request->category_description,
            'publication_status'=>$request->publication_status,

        ]);
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
