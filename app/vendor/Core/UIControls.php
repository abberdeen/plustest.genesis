<?php 
class UIControls{
    public static function tokenBox(){
        global $_user;
        $xsk=$_user->getSessKey();
        $sk=substr($xsk,0,2).'-'.substr($xsk,2,2);
        echo '<div id="pgSessKeyBox"  class="center no-select" style="visibility: visible; min-width:110px;max-width: 110px;min-height: 80px;max-height: 80px; vertical-align: middle;"   role="tooltip" data-toggle="tooltip"   title="1234">'.
                    '<div style="width: 12px;height: 12px;background: #6f6f6f;float: left;"></div>'.
                    '<div style="width: 12px;height: 12px;background: #6f6f6f;float: right;"></div>'.
                    '<center>'.
                        '<p style="font-size: 8px;color:#6f6f6f;margin: 0;">USER OPEN TOKEN</p>'.
                        '<p style="font-family: \'Segoe UI\'; font-size: 2rem; font-weight:500; color:#6f6f6f;margin: 0;">'.$sk.'</p>'.
                    '</center>'.
                    '<div  style="width: 12px;height: 12px;background: #6f6f6f;float: left;"></div>'.
                '</div>';
    }
}