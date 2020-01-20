<?php
class ViewExt{
    /**
     * Makes Breadcrumb items
     * @param $router
     * @param $match
     * @return array
     */
    public static function BreadcrumbItems($router,$match){
        $parent=$match['parent'];
        $breadcrumbItems=[];
        //Parent items
        while($parent!==null){
            $breadcrumbItems[]=
                [
                    'text'  =>app::t('',$parent),
                    'link'  =>$router->generate($parent),
                    'active'=> false
                ];
            $parent=$router->match($router->generate($parent))['parent'];
        }
        //Current item
        $breadcrumbItems=array_reverse($breadcrumbItems);
        $text=null;
        if(isset($match['params']['item'])){
            $text=$match['params']['item'];
        }
        else{
            $text=app::t('',$match['name']);
        }
        $breadcrumbItems[]=
            [
                'text'  => $text,
                'link'  => '',
                'active'=> true
            ];
        return $breadcrumbItems;
    }

    /**
     * Generates route path
     * Example: $source like this href='{{route gen|route_name|params}}'
     *       changes to like this href='/path/subpath/param1/paramN'
     * @param $router AltoRouter
     * @param $source string
     * @return string
     */
    public static function RouteGen(&$router,$source){
        $matches=null;
        preg_match_all("/\\{\\{route gen\\|(?<route>.*?)(\\|(?<params>.*?)|)\\}\\}/",$source,$matches);
        for($i=0;$i<count($matches);$i++){
            if(isset($matches['route'][$i])){
                $routeName=$matches['route'][$i];
                $params=[];
                foreach(explode("|",$matches['params'][$i]) as $p){
                    $params[explode("=",$p)[0]]=explode("=",$p)[1];
                }
                if(isset($routeName)&&$routeName!=''){
                    $source=str_replace($matches[0][$i],$router->generate($routeName,$params),$source);
                }
            }
        }
        return $source;
    }
}