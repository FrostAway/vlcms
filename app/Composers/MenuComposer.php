<?php

namespace App\Composers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Option;

class MenuComposer{
    
    protected $menu;
    protected $request;

    public function __construct(Menu $menu, Request $request) {
        $this->menu = $menu;
        $this->request = $request;
    }

    public function compose($view){
        $group_id = Option::get('main_menu');
        $group_id = $group_id ? $group_id : 2;
        $menus = $this->menu->getData([
            'group_id' => $group_id,
            'per_page' => -1,
            'fields' => ['menus.id', 'menus.parent_id', 'menu_type', 'type_id', 'menus.icon', 'open_type', 'menus.order', 'md.title', 'md.slug', 'md.link']
        ]);
        
        $nestedMenus = $this->generateMenus($menus);
        
        $view->with('nestedMenus', $nestedMenus);
    }
    
    public function generateMenus($items, $parent_id=0, $depth=0){
        $html = '';
        foreach ($items as $item){
            if($item->parent_id == $parent_id){
                $name = $item->title; 
                $object = $item->getObject();         
                if($object){
                    $name = $object->title;  
                }else{
                    $object = $item;
                }
                $url = $item->link;
                $item_route = $item->getItemRoute();
                if($item_route){
                    $url = route($item_route, ['id' => $item->type_id, 'slug' => $object->slug]);
                }
                $li_class = ''; 
                if($this->request->url() == $url){
                    $li_class = 'active';
                }
                $childs = $this->generateMenus($items, $item->id, $depth+1);
                if(trim($childs) != ''){
                    $html .= '<li class="nav-item dropdown '.$li_class.'">'
                            . '<a href="'.$url.'" class="nav-link dropdown-toggle" data-toggle="dropdown">'.$name.' <i class="fa fa-angle-down"></i></a>'
                            . '<ul class="dropdown-menu">'.$childs.'</ul>'
                            . '</li>';
                }else{
                    $html .= '<li class="nav-item '.$li_class.'">'
                            . '<a class="nav-link" href="'.$url.'">'.$name.'</a>'
                            . '</li>';
                }
            }
        }
        return $html;
    }

}
