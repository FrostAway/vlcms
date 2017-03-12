<?php

namespace App\Facades\Lang;

use App\Models\Lang;

class Local{
    protected $lang;
    
    public function __construct(Lang $lang) {
        $this->lang = $lang;
    }
    
    public function all($args=[]){
        return $this->lang->getData($args);
    }
    
    public function getCurrent($fields=['*']){
        return $this->lang->getCurrent(['id', 'name', 'code', 'icon']);
    }
    
    public function getId($code){
        return $this->lang->getId($code);
    }
    
    public function findByCode($code, $fields=['*']){
        return $this->lang->findByCode($code, $fields);
    }
    
    public function has($code){
        $item = $this->lang->findByCode($code, ['id']);
        if($item){
            return true;
        }
        return false;
    }
}

