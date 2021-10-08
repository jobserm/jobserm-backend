<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::with('jobs')->has('jobs')->get();
        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function show(Category $category) {
        return view('categories.show',[
            'category' => $category
        ]);
    }

    public function showBySlug($slug){
        $category = Category::whereName($slug)->firstOrFail();
        return view('categories.show', [
            'category' => $category
        ]);
    }
    
    public function edit(Category $category){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\CategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,Category $category) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        //
    }

}
