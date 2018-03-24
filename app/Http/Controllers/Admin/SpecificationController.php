<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Specification;
use App\Category;

use JsonSchema\Validator as JSONValidate;
use JsonSchema\Constraints\Constraint as Constraint;
use App\Http\Controllers\AdminBaseController;

Use File;

class SpecificationController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $specs = Specification::paginate(config('globalSettings.entries-per-page'));
        return view('admin.specs.specs',
            [
                'specs' => $specs
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.specs.specsCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'type' => 'required|string',
            'jsonOptions' => 'json'
        ]);

        $validator = new JSONValidate;

        $json = json_decode(request('jsonOptions'));
        //Check each option for valid format

        foreach($json as $obj) {
            $validator->validate(
                $obj,
                (object)[
                    "type"=>"object",
                    "properties"=>(object)[
                        "label"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                        "value"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                    ]
                ],
                Constraint::CHECK_MODE_NORMAL
            ); //validates, and sets defaults for missing properties
        }


        if ($validator->isValid()) {
            $spec = new Specification();
            $spec->name = request('name');
            $spec->slug = $this->createSlug(request('name'));
            $spec->type = request('type');
            $spec->options = request('jsonOptions');
            $spec->save();
            \Session::flash('flash_created',request('name') . ' has been created');
            return redirect('/admin/specifications');
        } else {
            return redirect('/admin/specifications/create')->withErrors("Error, Invalid Options");
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat =  Category::find($id);
            $specs = json_decode($cat->specifications);
            $returnArray = [];

            foreach($specs as $spec) {
                if($spec->id != '') {
                    $theSpec =  Specification::find($spec->id);
                    $indiv = array();
                    $indiv['id'] = $spec->id;
                    $indiv['name'] = $theSpec->name;
                    $indiv['slug'] = $theSpec->slug;
                    $indiv['type'] = $theSpec->type;
                    $indiv['options'] = $theSpec->options;
                    $indiv['default'] = $spec->defaultVal;
                    $returnArray[] = $indiv;
                }
            }
            $returnObj = json_encode($returnArray);
            return $returnObj;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spec = Specification::find($id);
        return view('admin.specs.specsEdit',
            [
                'spec' => $spec
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'id' => 'exists:specifications',
            'name' => 'required|string',
            'type' => 'required|string',
            'jsonOptions' => 'json'
        ]);

        $validator = new JSONValidate;

        $json = json_decode(request('jsonOptions'));
        //Check each option for valid format

        foreach($json as $obj) {
            $validator->validate(
                $obj,
                (object)[
                    "type"=>"object",
                    "properties"=>(object)[
                        "label"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                        "value"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                    ]
                ],
                Constraint::CHECK_MODE_NORMAL
            ); //validates, and sets defaults for missing properties
        }


        if ($validator->isValid()) {
            try {
                $spec = Specification::find($id);
                $spec->name = request('name');
                $spec->slug = $this->createSlug(request('name'));
                $spec->type = request('type');
                $spec->options = request('jsonOptions');
                $spec->save();
                \Session::flash('flash_created',request('name') . ' has been edited');
                return redirect('/admin/specifications');
            }
            catch(QueryException $e) {
                \Session::flash('flash_deleted','Error Editing Specification');
                return redirect('/admin/specifications');
            }

        } else {
            return redirect('/admin/specifications/create')->withErrors("Error, Invalid Options");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function createSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }
}
