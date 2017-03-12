<?php

namespace App\Models;

use DB;

class Option extends BaseModel
{
    protected $table = 'options';
    protected $primaryKey = 'option_key';
    
    public $incrementing = false; 

    protected $fillable = ['key', 'value', 'label', 'lang_code'];
    
    public $timestamps = false;
    
    public function rules(){
        return [
            'key' => 'required',
            'value' => 'required'
        ];
    }
    
    public function getData($args=[]){
        $opts = [
            'field' => ['*'],
            'orderby' => 'option_key',
            'order' => 'asc',
            'per_page' => 20,
            'key' => '',
            'page' => 1
        ];
        
        $opts = array_merge($opts, $args);
        
        $opts = array_merge($opts, $args);
        
        return self::where('option_key', 'like', '%'.$opts['key'].'%')
                ->orderby($opts['orderby'], $opts['order'])
                ->paginate($opts['per_page']);
    }
    
    public function updateItem($key, $value, $lang=null) {
        $this->validator(['key' => $key, 'value' => $value], $this->rules());
        
        $lang = $lang ? $lang : current_locale();
        return DB::table('options')->updateOrInsert(['option_key' => $key, 'lang_code' => $lang], ['value' => $value]);
    }
    
    public function updateAll($data){
        if($data){
            $langs = get_langs(['fields' => ['code']]);
            foreach ($langs as $lang){
                if(isset($data[$lang->code])){
                    $lang_data = $data[$lang->code];
                    foreach ($lang_data as $key => $value){
                        DB::table('options')->updateOrInsert(['option_key' => $key, 'lang_code' => $lang->code], ['value' => $value]);
                    }
                }
            }
        }
    }
    
    public function destroyData($ids) {
        if(!is_array($ids)){
            $ids = [$ids];
        }
        if($ids){
            return $this->model->whereIn('option_key', $ids)->delete();
        }
    }
}
