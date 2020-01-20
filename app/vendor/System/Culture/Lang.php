<?php
namespace System\Culture;
use System\Culture\LangCode;
/**
 * Class Lang
 * Language control
 */
final class Lang{

    /**
     * Lang list keys equal to language ISO code
     * @var array
     */
    public static $list=[
        LangCode::en=>
            [
                'code'=>LangCode::en,
                'active'=>false,
                'label'=>'English',
                'label-eo'=>'',
                'label-ru'=>'Английский',
                'label-tg'=>'Англисӣ',
                'label-uz'=>'',
            ],
        LangCode::eo=>
            [
                'code'=>LangCode::eo,
                'active'=>false,
                'label'=>'Esperanto',
                'label-en'=>'Esperanto',
                'label-ru'=>'Эсперанто',
                'label-tg'=>'Эсперанто',
                'label-uz'=>'',
            ],
        LangCode::ru=>
            [
                'code'=>LangCode::ru,
                'active'=>false,
                'label'=>'Русский',
                'label-en'=>'Russian',
                'label-eo'=>'',
                'label-tg'=>'Русӣ',
                'label-uz'=>'',
            ],
        LangCode::tg=>
            [
                'code'=>LangCode::tg,
                'active'=>true,
                'label'=>'Тоҷикӣ',
                'label-en'=>'Tajik',
                'label-eo'=>'',
                'label-ru'=>'Таджикский',
                'label-uz'=>'',
            ],
        LangCode::uz=>
            [
                'code'=>LangCode::uz,
                'active'=>false,
                'label'=>'Oʻzbekcha/ўзбекча',
                'label-en'=>'Uzbek',
                'label-eo'=>'',
                'label-ru'=>'Узбекский',
                'label-tg'=>'Ӯзбекӣ',
            ],

    ];

    public static function getLangByCode($code){
        return self::$list[$code];
    }

    public static function getList(){
        return self::$list;
    }

    /**
     * Returns true if lang exists and active
     */
    public static function isLang($langCode){
        if(!isset($langCode)) return false;

        if(isset(Lang::$list[$langCode])){
            if(Lang::$list[$langCode]['active']){
                return true;
            }
        }
        return false;
    }
}