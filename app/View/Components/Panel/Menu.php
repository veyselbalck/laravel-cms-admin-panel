<?php

namespace App\View\Components\Panel;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Support\HtmlString;

class Menu extends Component
{

    private $menu = array();

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu['dashboard'] = array(
            'name'      => "Gösterge Paneli",
            'icon'      => 'bx-home-circle',
            'href'      => route('home'),
            'active'    => request()->routeIs('home')
        );

        if(auth()->user()->hasPermission('contents', 'index')) {
            $this->menu['contents'] = array(
                'name' => "İçerikler",
                'icon' => 'bx-folder-plus',
                'href' => route('contents.index'),
                'active' => request()->routeIs('contents*')
            );
        }

        if(auth()->user()->hasPermission('posts', 'index')) {
            $this->menu['posts'] = array(
                'name' => "Blog",
                'icon' => 'bx-news',
                'href' => route('posts.index'),
                'active' => request()->routeIs('posts*')
            );
        }

        if(auth()->user()->hasPermission('products', 'index')) {
            $this->menu['products'] = array(
                'name' => "Locations",
                'icon' => 'bx-store-alt',
                'href' => route('products.index'),
                'active' => request()->routeIs('products*')
            );
        }

//        if(auth()->user()->hasPermission('testimonial', 'index')) {
//            $this->menu['testimonial'] = array(
//                'name' => "Müşteri Görüşleri",
//                'icon' => 'bx-user-plus',
//                'href' => route('testimonial.index'),
//                'active' => request()->routeIs('testimonial*')
//            );
//        }

        /*if(auth()->user()->hasPermission('contacts', 'index')) {
            $this->menu['contacts'] = array(
                'name' => "İletişim Bilgileri",
                'icon' => 'bx-location-plus',
                'href' => route('contacts.index'),
                'active' => request()->routeIs('contacts*')
            );
        }*/

        $this->getModules();

        if(auth()->user()->hasPermission('seo_redirect', 'index')) {
            $this->menu['seo_redirect'] = array(
                'name' => "SEO Yönlendirme",
                'icon' => 'bx-directions',
                'href' => route('seo_redirect.index'),
                'active' => request()->routeIs('seo_redirect*')
            );
        }

        $this->getSettings();
    }

    public function list(){
        $list['contents']     = array('name' => "İçerikler");
        $list['posts']        = array('name' => "Postlar/Bloglar");
        $list['products']     = array('name' => "Ürünler");
        $list['testimonial']  = array('name' => "Müşteri Görüşleri");
        $list['contacts']     = array('name' => "İletişim");
        $list['modules']      = array('name' => "Modüller");
        $list['seo_redirect'] = array('name' => "SEO Yönlendirme");
        $list['settings']     = array('name' => "Ayarlar");
        $list['users']        = array('name' => "Kullanıcılar");
        $list['roles']        = array('name' => "Kullanıcı Grupları");
        $list['languages']    = array('name' => "Diller");
        $list['country']      = array('name' => "Ülkeler");
        $list['city']         = array('name' => "Şehirler");

        return $list;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return $this->renderMenu($this->menu);
    }

    private function getModules(){
        if(auth()->user()->hasPermission('modules', 'index')){
            $modules = [];

            foreach (ModuleCategories() as $k => $v){
                if($v["create"]) {
                    $modules[$k] = array(
                        'name' => $v["name"],
                        'active' => false,
                        'href' => route('modules.index', ["code" => $k])
                    );
                }
            }

            $this->menu['modules'] = array(
                'name'      => "Modüller",
                'icon'      => 'bx-layout',
                'active'    => request()->routeIs('modules*'),
//                'href'      => route('modules.index'),
                'submenu' => $modules
            );
        }
    }

    private function getSettings(){
        $system = array();

        if(auth()->user()->hasPermission('settings', 'index')){
            $system['settings'] = array(
                'name' => "Ayarlar",
                'active' => request()->routeIs('settings*'),
                'href' => route('settings.index')
            );
        }

        // Users
        $users = $this->getUsers();
        if ($users){
            $system['users'] = array(
                'name' => "Kullanıcılar",
                'active' => false,
                'href' => '',
                'submenu' => $users
            );
        }


        // Localisation
        $localisation = $this->getLocalisation($system);
        if ($localisation){
            $system['localisation'] = array(
                'name' => "Yerelleştirme",
                'active' => false,
                'href' => '',
                'submenu' => $localisation
            );
        }


        if(!empty($system)){
            $this->menu['system'] = array(
                'name' => "Sistem",
                'icon' => 'bx-cog',
                'active' => false,
                'submenu' => $system
            );
        }
    }

    private function getUsers(){
        $users = array();

        if(auth()->user()->hasPermission('users', 'index')){
            $users['users'] = array(
                'name' => "Kullanıcılar",
                'active' => request()->routeIs('users*'),
                'href' => route('users.index')
            );
        }

        if(auth()->user()->hasPermission('roles', 'index')){
            $users['roles'] = array(
                'name' => "Kullanıcı Grupları",
                'active' => request()->routeIs('roles*'),
                'href' => route('roles.index')
            );
        }

        return $users;

    }
    private function getLocalisation(){
        $localisation = array();

        if(auth()->user()->hasPermission('languages', 'index')){
            $localisation['languages'] = array(
                'name' => "Diller",
                'active' => request()->is('languages*'),
                'href' => route('languages.index')
            );
        }

        if(auth()->user()->hasPermission('country', 'index')){
            $localisation['country'] = array(
                'name' => "Ülkeler",
                'active' => request()->is('country*'),
                'href' => route('country.index')
            );
        }

        if(auth()->user()->hasPermission('city', 'index')){
            $localisation['city'] = array(
                'name' => "Şehirler",
                'active' => request()->is('city*'),
                'href' => route('city.index')
            );
        }

        return $localisation;
    }


    private function renderMenu($menus){
//        dd($menus);
        $html = '';

        foreach ($menus as $key => $menu) {

            $name   = $menu['name'];
            $href   = empty($menu['href']) ? 'javascript:;' : $menu['href'];
            $icon   = empty($menu['icon']) ? '' : '<i class="menu-icon tf-icons bx '.$menu['icon'].'"></i>';

            $active = $menu['active'] ? 'active' : '';
            $li_class = 'menu-item';
            $li_class .= $menu['active'] ? ' active' : '';

            if (request()->get("code")) {
                if(strstr($href, "code=".request()->get("code"))) {
                    $active = 'active';
                    $li_class .= ' active';
                }
            }

            $submenu = '';

            if(!empty($menu['submenu'])){
                $submenu = empty($menu['submenu']) ? '' : $this->getSubMenu($menu['submenu']);

                $active = ' menu-toggle';
                if(strpos($submenu, 'active') !== false){
                    $li_class .= ' open';
                    $active = ' menu-toggle';
                }

            }
            $html .= '<li class="'. $li_class .'"><a href="'.$href.'" class="menu-link '.$active.'">'.$icon.'<div data-i18n="'.$name.'">'.$name.'</div></a>'.$submenu.'</li>';

        }

        return new HtmlString($html);
    }

    private function getSubMenu($submenu){
        return '<ul class="menu-sub">'.$this->renderMenu($submenu).'</ul>';
    }


}
