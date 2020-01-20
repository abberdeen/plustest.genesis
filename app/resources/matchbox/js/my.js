
function Refresh(l_id,r_id,xf){
    if (typeof(xf)==='undefined') xf = 0;

    if(getSide(l_id)==getSide(r_id)){
        var side=getSide(l_id);
        if(document.getElementById(side+"i"+getID(l_id)).value=="" || document.getElementById(side+"i"+getID(l_id)).value==null ){
            return false;
        }
        var left_id=null;
        var right_id=null;
        if(side=="l"){
            left_id=r_id;
            right_id=document.getElementById("li"+getID(l_id)).value;
        }
        else if(side=="r"){
           left_id=document.getElementById("ri"+getID(l_id)).value;
           right_id=r_id;
        }
        if(left_id!=null && right_id!=null){
            Clear(left_id);
            Clear(right_id);
            document.getElementById("li"+getID(left_id)).value=right_id;
            document.getElementById("ri"+getID(right_id)).value=left_id;
            document.getElementById("rc"+getID(right_id)).classList.add('clb'+getID(left_id));
            connect(document.getElementById("lc"+getID(left_id)),document.getElementById("rc"+getID(right_id)),"clb"+getID(left_id),5);
            if(xf==0) la_las(getID(left_id),getID(right_id));
        }
        else if(left_id==null){
            Clear(right_id);
        }
        else if(right_id==null){
            Clear(left_id);
        }
    }
    else{
        var left_id=null;
        var right_id=null;
        if(getSide(l_id)=="l") {
            left_id=l_id;
            right_id=r_id;
        }
        else {
            left_id=r_id;
            right_id=l_id;
        }
        if(left_id!=null && right_id!=null){
            Clear(left_id);
            Clear(right_id);
            document.getElementById("li"+getID(left_id)).value=right_id;
            document.getElementById("ri"+getID(right_id)).value=left_id;
            document.getElementById("rc"+getID(right_id)).classList.add('clb'+getID(left_id));
            connect(document.getElementById("lc"+getID(left_id)),document.getElementById("rc"+getID(right_id)),"clb"+getID(left_id),5);
            if(xf==0) la_las(getID(left_id),getID(right_id));
        }
        else if(left_id==null){
            Clear(right_id);
        }
        else if(right_id==null){
            Clear(left_id);
        }
    }
}
function getSide(e){
    if(e==null) return null;
    return e.toString().substr(0,1);
}
function getID(e){
    if(e==null) return null;
    return e.toString().substr(1,1);
}
function Disconnect(id){
    var elementExists = document.getElementById(id);
    if(elementExists!=null){
        document.getElementById(id).remove();
    }
}
function Clear(side_id, xf){
    if(side_id=="" || side_id==null) return 0;
    if(typeof(xf)==='undefined') xf = 0;
    var side=getSide(side_id);
    var side_value=document.getElementById(side+"i"+getID(side_id)).value;
    var left_id=null;
    var right_id=null;
    if (side_value=="" || side_value==null) {}
    else{
        if(side=="r"){
            left_id=getID(side_value);
            right_id=getID(side_id);
        }
        else{
            left_id=getID(side_id);
            right_id=getID(side_value);
        }
        Disconnect("lc"+left_id+"rc"+right_id);
        if(xf==0) la_las(left_id,0);
        document.getElementById("rc"+right_id).classList.remove('clb'+left_id);
        document.getElementById("ri"+right_id).value="";
        document.getElementById("li"+left_id).value="";
    }
}


function mouseover(e){
    e.classList.add("msvr");
}
function mouseleave(e){
    e.classList.remove("msvr");
}
function mouseclick(e){
    // Clear(e.toString());
}

function sortByMatch(){
    for(i=0;i<4;i++){
        var x=document.getElementById('li'+i).value.toString();
        if(x){
            var container1Id='container'+ i;
            var x2=document.getElementById(x).parentElement;
            var container2Id=x2.id;
            if(container1Id!==container2Id){
                swapContainerElements(container1Id,container2Id);
            }
        }
    }
    DNDAddEventListener();
    RefreshAll();
    document.cookie="sortBy=match;"+"max-age="+3600+";";
}

function sortByNumber(){
    for(i=0;i<6;i++){
        swapContainerElements('container'+i,document.getElementById('r'+i).parentElement.id);
    }
    DNDAddEventListener();
    RefreshAll();
    document.cookie="sortBy=number;"+"max-age="+3600+";";
}

function RefreshAll(){
    for(i=0;i<4;i++){
        var x=document.getElementById('li'+i).value;
        if(x){
            Refresh('l'+i,x);
        }
    }
}

function swapContainerElements(container1Id,container2Id){
    var tmpContainer=document.getElementById(container1Id).innerHTML;
    document.getElementById(container1Id).innerHTML=document.getElementById(container2Id).innerHTML;
    document.getElementById(container2Id).innerHTML=tmpContainer;
}


var pattern = /sortBy=(match)/g;
var text = document.cookie;
var result=pattern.exec(text);
if (result != null){
    if(result[1]=="match"){
        sortByMatch();
    }
}

RefreshAll();

