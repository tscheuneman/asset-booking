<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Building;
use App\Region;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function buildings()
    {
        $csvFile = file(public_path() . "/storage/other_files/asu buildings.csv");
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line);
        }

        foreach($data as $building) {
            $build = new Building();
            $build->name = $building[1];
            $build->longitude = $building[2];
            $build->latitude = $building[3];
            $build->save();
        }
        echo 'done';

    }

    public function regions()
    {
        $csvFile = file(public_path() . "/storage/other_files/campus.csv");
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line);
        }

        foreach($data as $building) {
            $reg = new Region();
            $reg->name = $building[1];
            $reg->longitude = $building[2];
            $reg->latitude = $building[3];
            $reg->save();
        }
        echo 'done';

    }
}
?>