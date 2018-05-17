<?php

use Illuminate\Database\Seeder;
use App\Specification;

class SpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSpec('Price', 'price', 'number', '[{"label": "", "value": ""}]');
    }

    public static function createSpec($name, $slug, $type, $options) {
        $setting = Specification::where('name', '=', $name)->first();
        if($setting == null) {
            $spec = new Specification();
            $spec->name = $name;
            $spec->slug = $slug;
            $spec->type = $type;
            $spec->required = true;
            $spec->options = $options;
            $spec->save();
        }

    }``
}
