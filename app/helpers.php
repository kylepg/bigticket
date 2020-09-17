<?php

function simpleSetting($setting_name, $setting_value = 'HAS_NOT_BEEN_SET', $setting_type = null){
    $setting = App\SimpleSetting::where('name','=',$setting_name)->first();
    if($setting_value === 'HAS_NOT_BEEN_SET' && !empty($setting)){
        return $setting->cast_value;
    }
    elseif($setting_value !== 'HAS_NOT_BEEN_SET'){

        $setting = App\SimpleSetting::updateOrCreate(
            [
                'name' => $setting_name
            ],
            [
                'value' => $setting_value,
                'type' => !empty($setting_type) ? $setting_type : gettype($setting_value)
            ]
        );
        return true;

        /*
        //!! UPDATE THIS FOR ERROR HANDLING PURPOSES !!//

        $cast_map = [
            'boolean' => 'boolean',
            'integer' => 'integer',
            'double' => 'float',
            'float' => 'float',
            'string' => 'string',
            'array' => 'array',
            'object' => 'object',
            'resource' => 'string',
            'resource (closed)' => 'string',
            'NULL' => 'null',
            'unknown type' => 'null',
            'date' => 'date',
            'date_time' => 'date_time'
        ];
        if(empty($setting)){
            $setting = new App\SimpleSetting();
            $setting->name = $setting_name;
        }
        if(!empty($setting_type) && array_key_exists($setting_type,$cast_map)){
            if($cast_map[$setting_type] === 'array' && gettype($setting_value) === 'array'){
                if($setting_value === [] || array_keys($setting_value) === range(0, count($setting_value) - 1))
            }
            if($setting_type ===
            $setting->type = $cast_map[$setting_type];
        }
        else{
            // gettype
        }
        */
    }
}
