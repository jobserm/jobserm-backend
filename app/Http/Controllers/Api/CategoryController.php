<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('create',Category::class);
    //    $validated = $request->validate([
    //        'categories_name' => ['required']
    //    ]);

       $validator = Validator::make($request->all(),[
           'category_name' => [
               Rule::unique('categories'),
           ],
       ])->validate();

       $category = new Category();
       $category->category_name = $request->input('category_name');
       $category->save();

       $jobs = $request->input('job');
       return $categories;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest  $request
     * @param  \App\Models\Catetory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,Category $category)
    {
        $this->authorize('update',$category);
        // $validated = $request->validate([
        //     'categories_name' => ['required']
        // ]);

        $validator = Validator::make($request->all(),[
            'category_name' => [
                Rule::unique('categories')->ignore($category),
            ],
        ])->validate();

       $category = new Category();
       $category->category_name = $request->input('category_name');
       $category->save();

       $jobs = $request->input('job');
       return $category;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete',$category);

        $category->delete();

        return response()-json(['message' => 'Successfully deleted']);
    }
}
