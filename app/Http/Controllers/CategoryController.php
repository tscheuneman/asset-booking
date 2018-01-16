<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cas;
use App\Category;
use App\Specification;

use JsonSchema\Validator as JSONValidate;
use JsonSchema\Constraints\Constraint as Constraint;

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
        $specs = Specification::get();
        return view('admin.categoryCreate',
            [
                'specs' => $specs
            ]
        );
    }


    public function store() {
        $cat = new Category();

        $this->validate(request(), [
            'name' => 'required|unique:categories',
            'specifications' => 'json',
            'description' => '',
        ]);

        $validator = new JSONValidate;

        $json = json_decode(request('specifications'));
        foreach($json as $obj) {
            $validator->validate(
                $obj,
                (object)[
                    "type"=>"object",
                    "properties"=>(object)[
                        "id"=>(object)[
                            "type"=>"integer",
                            "required"=>true
                        ],
                        "name"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                        "defaultVal"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                    ]
                ],
                Constraint::CHECK_MODE_NORMAL
            ); //validates, and sets defaults for missing properties
        }

        if ($validator->isValid()) {
            $cat->name = request('name');
            $cat->slug = $this->createSlug(request('name'));
            $cat->description = request('description');
            $cat->specifications = request('specifications');


            $cat->save();
            return redirect('/admin/categories');
        } else {
            return redirect('/admin/category/create')->withErrors("Error, Invalid Specification Entry");
        }

    }

    public static function createSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }

}
