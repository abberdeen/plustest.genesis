<?php
/* 
 * @package     PHP5 Wiki Parser
 * @author      Dan Goldsmith
 * @copyright   Dan Goldsmith 2012
 * @link        http://d2g.org.uk/
 * @version     {SUBVERSION_BUILD_NUMBER}
 * 
 * @licence     MPL 2.0
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 */
require_once(dirname(__FILE__) . '/../interface/startOfLine.interface.php');

class internallink implements startOfLine
{
    const regular_expression = '/(\[\[(([^\]]*?)\:)?([^\]]*?)([\|]([^\]]*?))?\]\]([a-z]+)?)/i';

    public function __construct()
    {

    }
    
    public function startOfLine($line) 
    {
        //So although were passed a line of text we might not actually need to do anything with it.
        return preg_replace_callback(internallink::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        //Url is in index 4
        $url        = $matches[4];
        $title      = "";
        $namespace  = "";
        
        if(array_key_exists(6, $matches) && $matches[6] !== "")
        {
            $title = $matches[6];
        }
        else
        {
            $title = $url;
            if(array_key_exists(7, $matches))
            {
                $title .= $matches[7];
            }
        }
        
        $title = preg_replace('/\(.*?\)/','',$title);
        $title = preg_replace('/^.*?\:/','',$title);
        
        if(array_key_exists(3, $matches))
        {
            $namespace = $matches[3];
        }
        
        //TODO: Image Namespace Support
        $config = wikiParser::getConfigINI();
        
        if(strtoupper($namespace) === "FILE")
        {
            return "<img src=\"" . $matches[4] . "\" alt=\"" . $matches[5] . "\"/>";
        }
        else
        {
            global $articleLang;
            if($namespace=='') {
                if($articleLang){
                    $namespace=$articleLang;
                }
                else{
                    $namespace="tg";
                }
            }
            return kb::a($namespace,$url,$title);
        }
    }
    
}

?> 
