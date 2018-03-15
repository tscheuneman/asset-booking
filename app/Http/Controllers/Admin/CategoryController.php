<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ProcessImage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Cas;
use App\Category;
use App\Specification;
use File;

use JsonSchema\Validator as JSONValidate;
use JsonSchema\Constraints\Constraint as Constraint;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $cat = Category::with('subcats.subcats')->where('toplevel', '=', true)->paginate(20);
        return view('admin.categories.category',
            [
                'categories' => $cat
            ]
        );
    }

    public function create() {
        $specs = Specification::get();
        $cat = Category::with('subcats.subcats')->where('toplevel', '=', true)->get(['id', 'name']);
        return view('admin.categories.categoryCreate',
            [
                'specs' => $specs,
                'cat' => $cat
            ]
        );
    }


    public function store(Request $request) {


        $this->validate(request(), [
            'name' => 'required|unique:categories',
            'specifications' => 'json',
            'marker' => 'required|image',
            'description' => 'required',
            'parent' => 'required|nullable|exists:categories,id'
        ]);


        try {
            $path = $request->file('marker')->store(
                'markers', 'public'
            );
        }
        catch(Exception $e) {
            \Session::flash('flash_deleted',request('name') . ' Error uploading file');
            return redirect('/admin/categories');
        }

        $validator = new JSONValidate;

        $json = json_decode(request('specifications'));
        foreach($json as $obj) {
            $validator->validate(
                $obj,
                (object)[
                    "type"=>"object",
                    "properties"=>(object)[
                        "id"=>(object)[
                            "type"=>"string",
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
            $theID = request('parent');
            $cat = new Category();

            $cat->name = request('name');
            if(request('parent') === null) {
                $cat->slug = $this->createSlug(request('name'));
            }
            else {
                $theCat = Category::find($theID);
                $cat->slug = $theCat->slug . '-' . $this->createSlug(request('name'));
            }
            $cat->marker_img = $path;
            $cat->description = request('description');
            if(request('parent') === null) {
                $cat->toplevel = true;
            }
            else {
                $cat->toplevel = false;

                $theCat = Category::find($theID);
                $cat->parent_cat = $theCat->id;
            }
            $cat->specifications = request('specifications');

            ProcessImage::dispatch($path, 14, 60);
            $cat->save();
            \Session::flash('flash_created',request('name') . ' has been created');
            return redirect('/admin/categories');
        } else {
            return redirect('/admin/category/create')->withErrors("Error, Invalid Specification Entry");
        }

    }

    public function edit($id)
    {
        $category = Category::find($id);
        $specs = Specification::get();
        $cat = Category::with('subcats.subcats')->where('toplevel', '=', true)->get(['id', 'name']);
        return view('admin.categories.categoryEdit',
            [
                'category' => $category,
                'specs' => $specs,
                'cat' => $cat,
                'parent' => 'required|nullable|exists:categories,id'
            ]
        );
    }

    public function update(Request $request, $id) {
        $this->validate(request(), [
            'id' => 'exists:categories',
            'name' => 'required',
            'specifications' => 'json',
            'marker' => 'image',
            'description' => 'required',
        ]);

        $validator = new JSONValidate;

        if(request('marker') != null) {
            try {
                $path = $request->file('marker')->store(
                    'markers', 'public'
                );
            }
            catch(Exception $e) {
                \Session::flash('flash_deleted',request('name') . ' Error uploading file');
                return redirect('/admin/categories');
            }
        }

        $json = json_decode(request('specifications'));
        foreach($json as $obj) {
            $validator->validate(
                $obj,
                (object)[
                    "type"=>"object",
                    "properties"=>(object)[
                        "id"=>(object)[
                            "type"=>"string",
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
            try{
                $theID = request('parent');
                $cat = Category::find($id);
                $cat->name = request('name');
                if(request('parent') === null) {
                    $cat->slug = $this->createSlug(request('name'));
                }
                else {
                    $theCat = Category::find($theID);
                    $cat->slug = $theCat->slug . '-' . $this->createSlug(request('name'));
                }
                $cat->description = request('description');
                if(request('parent') === null) {
                    $cat->toplevel = true;
                    $cat->parent_cat = null;
                }
                else {
                    $cat->toplevel = false;

                    $theCat = Category::find($theID);
                    $cat->parent_cat = $theCat->id;
                }

                $cat->specifications = request('specifications');
                if(request('marker') != null) {
                    File::delete(public_path(). '/storage/' . $cat->marker_img);
                    $cat->marker_img = $path;
                    ProcessImage::dispatch($path, 14, 60);
                }

                $cat->save();
                \Session::flash('flash_created',request('name') . ' has been edited');
                return redirect('/admin/categories');
            } catch(QueryException $e) {
                \Session::flash('flash_deleted','Error Editing Category' . $e->getMessage());
                return redirect('/admin/categories');
            }

        } else {
            return redirect('/admin/category/edit/'.$id)->withErrors("Error, Invalid Specification Entry");
        }

    }


    public static function createSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }

    public function getAllCategories() {
        return Category::orderBy('name', 'ASC')->get(['id', 'name']);
    }

}
