<?php

use Illuminate\Database\Seeder;
use App\Setting;
Use App\AdminSetting;

class GlobalSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSetting('Enable Cas', 'enable-cas', 'checkbox', 'Enable CAS for site?', true, false);
    }

    public static function createSetting($name, $slug, $type, $desc, $global, $val) {
        $setting = new Setting();
            $setting->name = $name;
            $setting->slug = $slug;
            $setting->type = $type;
            $setting->description = $desc;
            $setting->global = $global;
            $setting->admin = true;
        $setting->save();


        $adminSetting = new AdminSetting();
            $adminSetting->setting_id = $setting->id;
            $adminSetting->admin_id = '00000000-0000-0000-0000-000000000000';
            $adminSetting->value = $val;
        $adminSetting->save();
    }
}
