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
        $this->createSetting('Site Name', 'site-name', 'textbox', 'Name of site', true, "Asset Booking");
        $this->createSetting('Entries per Page', 'entries-per-page', 'number', 'Number of entries per page', true, 10);

        $this->createSetting('Default Email', 'default-email', 'email', 'Default email address to send entries too', true, 'example@example.com');

        $this->createSetting('Enable Cas', 'enable-cas', 'checkbox', 'Enable CAS for site?', true, true);
        $this->createSetting('Multi Level Categories', 'multi-level-cats', 'checkbox', 'Enable multi level categories', true, true);
        $this->createSetting('Orderable Categories', 'orderable-categories', 'checkbox', 'Enable orderable products', true, true);
        $this->createSetting('User Approval', 'user-approval', 'checkbox', 'Require user approval', true, true);
    }

    public static function createSetting($name, $slug, $type, $desc, $global, $defaultValue) {
        $setting = Setting::where('slug', '=', $slug)->first();
        if($setting == null) {
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
            $adminSetting->value = $defaultValue;
            $adminSetting->save();
        }

    }
}
