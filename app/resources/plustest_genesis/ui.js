
function Toggle(id,state){
    return "<div class=\"btn-group mr-2\" role=\"group\">"+
            ToggleButton(id,'No',state==false?'danger':'secondary')+
            ToggleButton(id,'Yes',state==true?'success':'secondary')
        +"</div>";
}

function ToggleButton(id,text,style){
    return "<button id="+id+"  name type=\"button\" class=\"toggle-"+text.toLowerCase()+" btn btn-"+style+" btn-sm\">"+text+"</button>";
}

