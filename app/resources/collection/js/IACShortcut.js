/**
 * This procedure for make short user name which based on ISU standard
 IACShortcut	Result
 !	            stud
 @	            st
 #	            pr
 $	            mt
 %	            vip
 */
var IACShortcuts={'!':'stud','@':'st','#':'pr','$':'mt','%':'vip','~':'st14690'};
function IACMakeShort(username){
    var uname=username.trim()
    var code=uname.substr(0,1);
    if(IACShortcuts[code]){
        return IACShortcuts[code]+uname.substr(1);
    }
    return username;
}
pgUsername.addEventListener('keyup', function handleKeyUp(e){
    var s=IACMakeShort(this.value);
    if(this.value!=s){
        this.value=IACMakeShort(this.value);
    }
},false);