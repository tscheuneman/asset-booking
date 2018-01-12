<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specification;

use JsonSchema\Validator as JSONValidate;
use JsonSchema\Constraints\Constraint as Constraint;

Use File;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $specs = Specification::get();
        return view('admin.specs',
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
        return view('admin.specsCreate');
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
            'default' => 'required|string',
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
            $spec->default = request('default');
            $spec->options = request('jsonOptions');
            $spec->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
