<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cas;
use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $cat = Category::get();
        return view('admin.category',
            [
                'categories' => $cat
            ]
        );
    }

    public function create() {
        return view('admin.categoryCreate');
    }


    public function store() {
        $cat = new Category();

        $this->validate(request(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'description' => '',
        ]);

        $cat->name = request('name');
        $cat->slug = request('slug');
        $cat->description = request('description');

        $cat->save();
        return redirect('/admin/assets/categories');
    }

}
