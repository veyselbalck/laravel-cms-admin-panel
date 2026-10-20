<?php

use App\Models\Contents;
use App\Models\ContentsDescription;
use App\Models\Panel\Modules;

if (!function_exists('array_flat')) {
    function array_flat($array, $prefix='')
    {
        $result=array();

        foreach ($array as $key=>$value) {
            $new_key=$prefix . (empty($prefix) ? '' : '.') . $key;

            if (is_array($value)) {
                $result=array_merge($result, array_flat($value, $new_key));
            } else {
                $result[$new_key]=$value;
            }
        }

        return $result;
    }
}

if (! function_exists('frontend')) {
    /**
     * @return \App\Http\Controllers\FrontendController
     */
    function frontend(){
        if (app()->isShared('frontend'))
            return app('frontend');
        return null;
    }
}

if (! function_exists('isFrontend')) {
    /**
     * @return \App\Http\Controllers\FrontendController
     */
    function isFrontend(){

        return app()->isShared('frontend');
    }
}

if (! function_exists('form')) {
    /**
     * @return \App\Library\Form
     */
    function form(){
        return app('form');
    }
}

if (! function_exists('getLanguages')) {
    /**
     * @param string $key
     * @param string $value
     * @return Illuminate\Support\Collection
     */
    function getLanguages($key = 'code', $value = 'name'){
        return \App\Models\Panel\Languages::where('status', 1)->get()->pluck($value, $key);
    }
}

if (! function_exists('getModelLanguages')) {
    /**
     * @param string $key
     * @param string $value
     * @return Illuminate\Support\Collection
     */
    function getModelLanguages(){
        return \App\Models\Panel\Languages::where('status', 1)->get();
    }
}

if (! function_exists('getLanguagesByCodeId')) {
    /**
     * @return Illuminate\Support\Collection
     */
    function getLanguagesByCodeId(){
        return \App\Models\Panel\Languages::where('status', 1)->get()->pluck('id' , 'code');
    }
}

if (! function_exists('getLanguageId')) {
    /**
     */
    function getLanguageId(){
        return \App\Models\Panel\Languages::where('status', 1)->where('code', config('app.locale'))->first()->id;
    }
}

if (! function_exists('getLanguageById')) {
    /**
     * @param $language_id
     * @return Illuminate\Support\Collection
     */
    function getLanguageById($language_id){
        return \App\Models\Panel\Languages::where('status', 1)->where('id', $language_id)->first();
    }
}

if (! function_exists('limit')) {
    /**
     * Translate the given message.
     *
     * @param $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }
}

if (! function_exists('log_add')) {
    /**
     * Translate the given message.
     *
     * @param $subject
     * @return string
     */
    function log_add($subject)
    {
        if(auth()->user()->logs->count() > 250){ // 100 tane logu açtıktan sonra en önceki logo silelim.
            auth()->user()->logs()->orderBy('id', 'ASC')->first()->delete();
        }

        \App\Models\Panel\LogActivity::create(array(
            'subject' => $subject,
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'ip' => Request::ip(),
            'user_id' => auth()->user()->id,
        ));

    }
}

if (! function_exists('_url')) {
    /**
     * Translate the given message.
     *
     * @param $append
     * @param array $parameters
     * @return string
     */
    function _url($append, $parameters = array())
    {
        if($parameters){
            request()->request->add($parameters);
        }
        $current = '/admin/' . request()->segment(2) . '/' . $append;
        $query = http_build_query(request()->all());

        return $query ? $current . '?' . $query : $current;
    }
}

if (! function_exists('_urlTo')) {
    /**
     * Translate the given message.
     *
     * @param string $url
     * @param null $add_to
     * @param null $remove_from
     * @param bool $clear_all
     * @return string
     */
    function _urlTo($url = '', $add_to = null, $remove_from = null, $clear_all = false)
    {

        if ($clear_all){
            $query_string = array();
        }else{
            parse_str(request()->getQueryString(), $query_string);
        }
        if($add_to){
            foreach($add_to as $key=>$value){
                $query_string[$key] = $value;
            }
        }

        if($remove_from){
            foreach ($remove_from as $keys) {
                unset($query_string[$keys]);
            }

        }

        return empty($query_string) ? $url : $url . '?' . http_build_query($query_string,'','&');
    }
}

if (! function_exists('_route')) {
    /**
     * Translate the given message.
     *
     * @param $target
     * @param array|string $parameters
     * @param bool $absolute
     * @return string
     */
    function _route($target, $parameters = null , $absolute = true)
    {
        $parse = explode('.', request()->route()->getName());
        $targets = array($parse[0], $target);
        return route(implode('.', $targets),$parameters, $absolute);
    }
}



if (! function_exists('getTreePost')) {
    function getTreePost($elements, $parentId = 0, $keys = []) {
        $branch = array();
        foreach ($elements as $element) {
            if(is_array($element))
                $element = (object)$element;

            if($keys){
                $element_arr = array();
                $element_arr['key'] = $element->key;
                $element_arr['title'] = str_replace("'", " ", $element->title);
                foreach ($keys as $key) {
                    $element_arr[$key] = str_replace("'", " ", $element[$key]);
                }
//                $element_arr['children'] = $element->children;
                $branch[] = $element_arr;
            }else{
                if(is_array($elements)){
                    $branch[] = collect($element)->toArray();
                }else{
                    $branch[] = $element;
                }

            }
        }
        if(is_array($elements)){
            return $branch;
        }
        return collect($branch);
    }
}

if (! function_exists('getTree')) {
    function getTree($elements, $parentId = 0, $keys = []) {

        $branch = array();
        foreach ($elements as $element) {
            if(is_array($element))
                $element = (object)$element;

            if ($element->parent_id == $parentId) {
                $children = getTree($elements, $element->id, $keys);
                $element->children = $children;
                if($keys){
                    $element_arr = array();
                    $element_arr['key'] = $element->key;
                    $element_arr['title'] = str_replace("'", " ", $element->title);
                    foreach ($keys as $key) {
                        $element_arr[$key] = str_replace("'", " ", $element[$key]);
                    }
                    $element_arr['children'] = $element->children;
                    $branch[] = $element_arr;
                }else{
                    if(is_array($elements)){
                        $branch[] = collect($element)->toArray();
                    }else{
                        $branch[] = $element;
                    }

                }

            }
        }
        if(is_array($elements)){
            return $branch;
        }
        return collect($branch);
    }
}

if (! function_exists('status')) {
    /**
     * Translate the given message.
     *
     * @param $status
     * @param int $type
     * @param $id
     * @return string
     */
    function status($status, $type = 1, $id = null)
    {
        switch ($type){
            case 1:
                return $status ? '<td class="text-center" width="120"><span class="badge bg-info">AKTİF</span></td>' : '<td class="text-center" width="120"><span class="badge bg-danger">PASİF</span></td>';
                break;
            case 2:
                return $status ? '<td class="text-center" width="100"><i class="icon-checkmark3 text-success"></i></td>' : '<td class="text-center" width="100"><i class="icon-cross text-danger"></i></td>';
                break;
            case 3:
                return view('panel.component.status', array('status' => $status, 'id' => $id));
                break;
        }
    }
}

if (! function_exists('cartTitle')) {
    /**
     * Translate the given message.
     *
     * @param $model
     * @return string
     */
    function cartTitle($text)
    {
        $parse = explode('-', $text);
        $res = "";
        foreach ($parse as $k => $item) {
            if(count($parse) - 1 == $k)
                $res .= trim($item);
            else
                $res .= '<span class="text-muted fw-light">'.trim($item).' / </span>';
        }

        return $res;

//        $first = isset($parse[0]) ? $parse[0] : '';
//        $first_dot = isset($parse[1]) ? ' / ' : '';
//        $second = isset($parse[1]) ? $parse[1] : '';
//        return '<span class="text-muted fw-light">'.$first.$first_dot.'</span>' . $second;
    }
}

if (! function_exists('_user_role')) {
    function _user_role($role) {
        return Auth::user()->role == $role ? true : false;
    }
}

if (! function_exists('date_tr')) {
    /**
     * Translate the given message.
     *
     * @param $f
     * @param string $zt
     * @return string
     */
    function date_tr($f, $zt='now')
    {
        $f = empty($f) ? 'd M Y l H:i' : $f;
        $z=date("$f", strtotime($zt));
        $donustur=array(
            'Monday'=>'Pazartesi',
            'Tuesday'=>'Salı',
            'Wednesday'=>'Çarşamba',
            'Thursday'=>'Perşembe',
            'Friday'=>'Cuma',
            'Saturday'=>'Cumartesi',
            'Sunday'=>'Pazar',
            'January'=>'Ocak',
            'February'=>'Şubat',
            'March'=>'Mart',
            'April'=>'Nisan',
            'May'=>'Mayıs',
            'June'=>'Haziran',
            'July'=>'Temmuz',
            'August'=>'Ağustos',
            'September'=>'Eylül',
            'October'=>'Ekim',
            'November'=>'Kasım',
            'December'=>'Aralık',
            'Mon'=>'Pts',
            'Tue'=>'Sal',
            'Wed'=>'Çar',
            'Thu'=>'Per',
            'Fri'=>'Cum',
            'Sat'=>'Cts',
            'Sun'=>'Paz',
            'Jan'=>'Oca',
            'Feb'=>'Şub',
            'Mar'=>'Mar',
            'Apr'=>'Nis',
            'Jun'=>'Haz',
            'Jul'=>'Tem',
            'Aug'=>'Ağu',
            'Sep'=>'Eyl',
            'Oct'=>'Eki',
            'Nov'=>'Kas',
            'Dec'=>'Ara',
        );
        foreach ($donustur as $en=>$tr) {
            $z=str_replace($en, $tr, $z);
        }
        if (strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z=str_replace('Mayıs', 'May', $z);
        return $z;
    }
}

if (! function_exists('date_lang')) {
    /**
     * Translate the given message.
     *
     * @param $f
     * @param string $zt
     * @return string
     */
    function date_lang($f, $zt='now')
    {
        $f          = empty($f) ? 'd M Y l H:i' : $f;
        $z          = date("$f", strtotime($zt));
        $donustur   = __("date.date_text");
        foreach ($donustur as $en => $tr) {
            $z = str_replace($en, $tr, $z);
        }
        if (strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z=str_replace('Mayıs', 'May', $z);
        return $z;
    }
}

if (! function_exists('getCountry')) {
    function getCountry(){
        return \App\Models\Panel\Country::all()->pluck('name' , 'id');
    }
}

if (! function_exists('getCity')) {
    function getCity($country_id){
        return \App\Models\Panel\City::where('country_id', $country_id)->get()->pluck('name' , 'id');
    }
}

if (! function_exists('timezone_list')) {
    function timezone_list()
    {
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['offset'] = (int) ((int) date('O', $timestamp))/100;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }
}

if (! function_exists('getContentSlug')) {
    function getContentSlug($data, $language_id = null) {

        if($language_id == null)
            $language_id = config('app.language_id');

        $url = str_replace(["https://", "http://"], "", config('app.url')) . '/';


        // language
        $language_code = !empty(getLanguageById($language_id)->code) ? getLanguageById($language_id)->code : "";

        if (getLanguageCount() > 1)
            $url .= $language_code;

        $parent = !empty($data->parent) ? $data->parent : "";

        $slugs = [];
        again:
        if($parent){
            $description = $parent->description($language_id);
            if($parent->subdomain == null){
                if($description && $description->slug){
                    $slugs[] = $description->slug;
                } else {
                    if (getLanguageCount() > 1)
                        return '//' .config('app.url') . '/' . $language_code;
                    else
                        return '//' .config('app.url');

                }
            }

            $parent = $parent->parent;
            goto again;
        }

        if ($slugs){
            $slugs = array_reverse($slugs);
            if (getLanguageCount() > 1)
                $url .= '/' . implode('/', $slugs);
            else
                $url .= implode('/', $slugs);
        }

        if($data->subdomain == null){
            $description = $data->description($language_id);
            if($description && $description->slug){
                $url .= '/' . $description->slug;
            }
        }

        // subdomain
//        if($data->ParentTop->subdomain){
//            $url = $data->ParentTop->subdomain . '.' . config('app.url') . '/' . $url;
//        }else{
//            $url = config('app.url') . '/' . $url;
//        }


        return '//' . str_replace("//", "/", $url);
    }
}

if (! function_exists('contentCount')) {
    function dashboardCounter($table, $type=null)
    {
        $count = 0;
        switch ($table) {
            case "contents":
                $query = new \App\Models\Panel\Contents();
                if ($type == null)
                    $query = $query->where("content_type", "!=","post");
                elseif($type == "post")
                    $query = $query->where("content_type", "=","post");
                elseif($type == "product")
                    $query = $query->where("content_type", "=","product");

                $count = $query->count();
                break;

            case "module":
                $query = new \App\Models\Panel\Modules();
                if ($type != null)
                    $query = $query->where("code", "=", $type);

                $count = $query->count();
                break;

            case "seo_redirect":
                $query = new \App\Models\Panel\SeoRedirect();
                $count = $query->count();
                break;

            case "users":
                $query = new \App\Models\Panel\User();
                $count = $query->count();
                break;

            case "languages":
                $query = new \App\Models\Panel\Languages();
                $count = $query->count();
                break;

            case "settings":
                $query = new \App\Models\Panel\Settings();
                $query = $query->where("code", "config")->first();
                foreach ($query->value as $key => $item) {
                    $count += count($item);
                }
                break;
        }

        return $count;
    }
}

if (! function_exists('templates')) {
    function templates($type = null)
    {
        $templates = [
            "default" => "Default",
            "home" => "Home",
            "fullwith" => "Full With",
            "products" => "Ürünler",
        ];

        if($type == "post") {
            $templates = [
                "blog" => "Blog/Post",
            ];
        }

        if($type == "product") {
            $templates = [
                "product" => "Ürün",
            ];
        }

        return $templates;
    }
}

if (! function_exists('contentTypes')) {
    function contentTypes($type = null)
    {
        $array = [
            "page" => "Sayfa",
            "products" => "Ürün" ,
            "posts" => "Bloglar/Postlar",
        ];

        if($type == "post") {
            $array = [
                "post" => "Blog/Post",
            ];
        }

        if($type == "products") {
            $array = [
                "products" => "Ürünler",
            ];
        }

        if($type == "product") {
            $array = [
                "product" => "Ürün Sayfası",
            ];
        }

        return $array;
    }
}

if (! function_exists('contents')) {
    function contents($type = null, $id_not = null)
    {
        $contents = new \App\Models\Panel\Contents();

        if($type)
            $contents = $contents->where("content_type", $type);

        if($id_not)
            $contents = $contents->where("id", "!=", $id_not);

        return $contents->orderBy("title", "asc")->get();
    }
}

if (! function_exists('LayoutBlocks')) {
    function LayoutBlocks()
    {
        $blocks = [
            'top' => [
                'name' => 'Üst Blokta',
                'col' => 'col-12'
            ],
            'left' => [
                'name' => 'Orta Sol Blokta',
                'col' => 'col-md-3 col-12'
            ],
            'center' => [
                'name' => 'Orta Blokta',
                'col' => 'col-md-6 col-12'
            ],
            'right' => [
                'name' => 'Orta Sağ Blokta',
                'col' => 'col-md-3 col-12'
            ],
            'bottom' => [
                'name' => 'Alt Blokta',
                'col' => 'col-12'
            ],
        ];

        return json_decode(json_encode($blocks));
    }
}

if (! function_exists('menuTypes')) {
    function menuTypes()
    {
        $array = [
            "main_menu" => "Ana Menü",
//            "top_left" => "Üst Menü (Sol)",
//            "top_right" => "üst Menü (Sağ)",
            "footer" => "Footer Parent Sayfa",
            "info_page" => "Bilgi Sayfaları (Copyright)",
            "product_contents" => "Footer Ürünler",
            "contents" => "Footer Hızlı Menü",
            "brands" => "Footer Markalar",
        ];

        return $array;
    }
}

if (! function_exists('Modules')) {
    function Modules() {
        $modules = [];
        foreach (ModuleCategories() as $key => $value) {
            $childs = [];
            $moduleQuery = Modules::where("code", $key)->get();
            foreach ($moduleQuery as $item) {
                $childs[$item->id] = [
                    'name' => $item->name,
                    'no_updated' => $item->no_updated,
                ];
            }
            $modules[] = [
                'name' => $value["name"],
                'key' => $key,
                'children' => $childs
            ];
        }
        return $modules;
    }
}

if (! function_exists('getLanguageCount')) {
    /**
     * @return Illuminate\Support\Collection
     */
    function getLanguageCount(){
        return \App\Models\Panel\Languages::active()->count();
    }
}

if (! function_exists('home_route')) {
    /**
     * @return Illuminate\Support\Collection
     */
    function home_route($lang){
        return getLanguageCount() > 1 ? route("frontend", $lang) : route("frontend");
    }
}

if (! function_exists('ModuleItemsBubbleSort')) {
    function ModuleItemsBubbleSort($array)
    {
        $sort_error = 0;
        $old_array = $array;
        do
        {
            $swapped = false;
            for( $i = 0, $c = count($array) - 1; $i < $c; $i++ )
            {
                if(!empty($array[$i]["sort_order"])) {
                    if ($array[$i]["sort_order"] > $array[$i + 1]["sort_order"]) {
                        list($array[$i + 1], $array[$i]) = array($array[$i], $array[$i + 1]);
                        $swapped = true;
                    }
                } else
                    $sort_error++;
            }
        }
        while( $swapped );

        if($sort_error)
            return $old_array;

        return $array;
    }
}

if (! function_exists('getContentModuleDescription')) {
     function getContentModuleDescription($description, $lang_id){

        if ( false === strpos( $description, '[module' ) ) {
            return $description;
        }

        preg_match_all('/\[(module)\](.*?)\[\/\1\]?/', $description, $matches);

        if($matches){
            foreach ($matches[2] as $key => $match) {

                $parse_match = explode('.', $match);
                if($parse_match && count($parse_match) > 1){
                    $module_id      = $parse_match[1];
                    $module_result = \App\Models\Modules::find($module_id);
                    $html = '';

                    if($module_result){

                        $module["code"] = $parse_match[0];
                        $module["id"]   = $module_id;
                        if(view()->exists('frontend.module.' .$module_result->code)){
                            $items = [];
                            $items2 = [];
                            $extra_fields = $module_result->settings;
                            if(is_null($extra_fields)){
                                $extra_fields = [];
                            }
                            unset($extra_fields['items']);
                            unset($extra_fields['items2']);
                            unset($extra_fields['list']);

                            if (isset($module_result->settings['items'][$lang_id])){
                                $items =  json_decode(json_encode($module_result->settings['items'][$lang_id]), 1);

                                if (!empty($module_result->settings['items'][$lang_id])) {
                                    $items = $module_result->settings['items'][$lang_id];
                                    $array = [];
                                    foreach ($items as $item) {
                                        $array[] = $item;
                                    }
                                    $array2 = [];
                                    $index = 19857525;
                                    foreach (ModuleItemsBubbleSort($array) as $item) {
                                        $array2[$index] = $item;
                                        $index++;
                                    }
                                    $items = $array2;
                                }
                            }

                            if (isset($module_result->settings['items2'])){
                                if (!empty($module_resultult->settings["items2"])) {
                                    $items2 = $module_resultult->settings["items2"];
                                    $array = [];
                                    foreach ($items2 as $item) {
                                        $array[] = $item;
                                    }
                                    $array2 = [];
                                    $index = 19857525;
                                    foreach (ModuleItemsBubbleSort($array) as $item) {
                                        $array2[$index] = $item;
                                        $index++;
                                    }
                                    $items2 = $array2;
                                }
                            }

                            $lists = [];
                            if (isset($module_result->settings['list'])) {
                                foreach ($module_result->settings['list'] as $v) {
                                    $description = ContentsDescription::where("language_id", frontend()->getLanguageId())->where("contents_id", $v)->first();
                                    $result = Contents::leftJoin('contents_description', 'contents.id', '=', 'contents_description.contents_id')
                                        ->where('contents_description.language_id', frontend()->getLanguageId())
                                        ->where("id", $v)
                                        ->first();
                                    $lists[] = [
                                        'image' => $result->image,
                                        'name' => $description->name,
                                        'slug' => getContentSlug($result, frontend()->getLanguageId(), false),
                                        'datas' => json_decode($description->datas),
                                        'contentData' => json_decode($result->content_datas),
                                    ];
                                }
                            }

                            $settings = array_merge($module, $extra_fields);

                            $module_title       = !empty($settings['translation'][frontend()->getLanguageId()]["title"]) ? $settings['translation'][frontend()->getLanguageId()]["title"] : "";
                            $module_description = !empty($settings['translation'][frontend()->getLanguageId()]["description"]) ? $settings['translation'][frontend()->getLanguageId()]["description"] : "";
                            $module_button      = !empty($settings['translation'][frontend()->getLanguageId()]["button_name"]) ? $settings['translation'][frontend()->getLanguageId()]["button_name"] : "";
                            $module_btn_link    = !empty($settings['translation'][frontend()->getLanguageId()]["button_link"]) ? $settings['translation'][frontend()->getLanguageId()]["button_link"] : "";

                            $html = view('frontend.module.' . $module['code'], [
                                    'settings'              => $settings,
                                    'lists'                 => json_decode(json_encode($lists)),
                                    'module'                => $module_result,
                                    'template'              => $module_result->template,
                                    'items'                 => $items,
                                    'items2'                => $items2,
                                    'module_title'          => $module_title,
                                    'module_description'    => $module_description,
                                    'module_button'         => $module_button,
                                    'module_btn_link'       => $module_btn_link,
                                ])->render() . PHP_EOL;
                        }
                    }
                    $description = str_replace('<p>[module]' . $match . '[/module]</p>', '[module]' . $match . '[/module]', $description);
                    $description = str_replace('[module]' . $match . '[/module]', $html, $description);
                }
            }
        }
        return $description;

    }
}

if (! function_exists('ModuleCategories')) {
    function bubble_Sort($array)
    {
        $sort_error = 0;
        $old_array = $array;
        do {
            $swapped = false;
            for ($i = 0, $c = count($array) - 1; $i < $c; $i++) {
                if (!empty($array[$i]["sort_order"])) {
                    if ($array[$i]["sort_order"] > $array[$i + 1]["sort_order"]) {
                        list($array[$i + 1], $array[$i]) = array($array[$i], $array[$i + 1]);
                        $swapped = true;
                    }
                } else
                    $sort_error++;
            }
        } while ($swapped);

        if ($sort_error)
            return $old_array;

        return $array;
    }
}

if (! function_exists('ModuleCategories')) {
    function ModuleCategories()
    {
        $blocks = [
            "carousel" => [
                'name' => "Carousel",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
//            "banner" => [
//                'name' => "Banner",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
//            "breadcrumb" => [
//                'name' => "Breadcrumb",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
            "html" => [
                'name' => "Kod Editör",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
            "contents" => [
                'name' => "Kategori Listele",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
//            "posts" => [
//                'name' => "Blog Listele",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
//            "modal_popup" => [
//                'name' => "Modal Popup",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
            "space" => [
                'name' => "Space",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
//            "tabs_collapse" => [
//                'name' => "Tabs-Collapse İçerik",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
            "childrens" => [
                'name' => "Alt İçerikleri Listele",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
//            "gallery" => [
//                'name' => "Galeri İçerik",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
//            "galeriKategori" => [
//                'name' => "Galeri Liste",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
            "media_img_video" => [
                'name' => "Medya Görsel ve Video",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
//            "media_file" => [
//                'name' => "Dokümanlar",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
//            "form"              => [
//                'name' => "Formlar",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
//            "contacts"              => [
//                'name' => "İletişim Bilgileri",
//                'create' => true,
//                'add' => true,
//                'copy' => true,
//                'delete' => true
//            ],
            "menu"              => [
                'name' => "Menüler",
                'create' => true,
                'add' => true,
                'copy' => true,
                'delete' => true
            ],
            "contentDescription"=> [
                'name' => "İçerik Açıklaması",
                'create' => false,
                'add' => false,
                'copy' => false,
                'delete' => false
            ],
            "tags"=> [
                'name' => "Etiketler",
                'create' => false,
                'add' => false,
                'copy' => false,
                'delete' => false
            ],
//            "ready-forms"       => [
//                'name' => "Formlar",
//                'create' => false,
//                'add' => false,
//                'copy' => false,
//                'delete' => false
//            ],
//            "testimonials"      => [
//                'name' => "Görüşler",
//                'create' => false,
//                'add' => false,
//                'copy' => false,
//                'delete' => false
//            ],
            "home-news"         => [
                'name' => "Haberler",
                'create' => false,
                'add' => false,
                'copy' => false,
                'delete' => false
            ],
            "contact-infos"     => [
                'name' => "İletişim",
                'create' => false,
                'add' => false,
                'copy' => false,
                'delete' => false
            ],
            "about-home"        => [
                'name' => "Hakkımızda",
                'create' => true,
                'add' => true,
                'copy' => false,
                'delete' => false
            ],

//            "team"        => [
//                'name' => "Ekibimiz",
//                'create' => true,
//                'add' => true,
//                'copy' => false,
//                'delete' => false
//            ],
        ];

//        asort($blocks);
        ksort($blocks);

//        return json_decode(json_encode($blocks));
        return $blocks;
    }
}
