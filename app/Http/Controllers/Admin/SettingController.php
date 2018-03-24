<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Factory;

use App\Http\Controllers\AdminBaseController;

use App\Setting;
use App\AdminSetting;

use Validator;
use JsonSchema\Validator as JSONValidate;
use JsonSchema\Constraints\Constraint as Constraint;


class SettingController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $globalSetting = Setting::with('adminSetting')->where('global', '=', true)->get();
        return view('admin.settings.settings',
            [
                'globalSetting' => $globalSetting
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function globalUpdate(Factory $cache) {
        $validator = new JSONValidate;

        $json = json_decode(request('data'));
        //Check each option for valid format
        $falseReturn = false;
        $returnData = array();

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
                        "type"=>(object)[
                            "type"=>"string",
                            "required"=>true
                        ],
                        "value"=>(object)[
                            "type"=>["boolean", "string"],
                            "required"=>true
                        ],
                    ]
                ],
                Constraint::CHECK_MODE_NORMAL
            ); //validates, and sets defaults for missing properties
        }
        if ($validator->isValid()) {
            foreach($json as $obj) {
                if($this->validateSetting($obj->id, true)) {
                    $adminSetting = AdminSetting::where('setting_id', '=', $obj->id)->first();
                     $adminSetting->value = $obj->value;
                     $adminSetting->save();
                }
                else {
                    $falseReturn = true;
                    break;
                }
            }

            if($falseReturn) {
                $returnData['status'] = 'Error';
                $returnData['message'] = 'That There was an error saving your settings';
                return json_encode($returnData);
            }

            $cache->forget('globalSettings');

            $returnData['status'] = 'Sucesss';
            $returnData['message'] = 'Settings have been saved';
            return json_encode($returnData);

        }

        $returnData['status'] = 'Error';
        $returnData['message'] = 'There was an error saving your settings';
        return json_encode($returnData);

    }

    private function validateSetting($id, $global) {
        $setting = Setting::where('global', '=', $global)->find($id);
        if($setting != null) {
            return true;
        }
        return false;
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
}
