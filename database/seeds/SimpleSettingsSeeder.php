<?php

use Illuminate\Database\Seeder;
use App\SimpleSetting;

class SimpleSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_simple_settings = [
            [
                'name' => 'is_celtics_gameday',
                'value' => 'false',
                'type' => 'boolean'
            ],
        ];
        foreach($default_simple_settings as $this_setting){
            SimpleSetting::updateOrCreate(
                [
                    'name' => $this_setting['name']
                ],
                [
                    'value' => $this_setting['value'],
                    'type' => $this_setting['type']
                ]
            );
        }
    }
}
