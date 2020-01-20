function getOffset( el ) {
    var rect = el.getBoundingClientRect();
    return {
        left: rect.left + window.pageXOffset,
        top: rect.top + window.pageYOffset,
        width: rect.width || el.offsetWidth,
        height: rect.height || el.offsetHeight
    };
}

function connect(div1, div2, class_name, thickness) { // draw a line connecting elements
    var off1 = getOffset(div1);
    var off2 = getOffset(div2);
    var off3 = getOffset(document.getElementById("pgTaskContent")); //will draw relate to pgTaskContent
    // bottom right
    var x1 = off1.left + off1.width-15-( off3.left);
    var y1 = off1.top +((off1.height)/2)-( off3.top);
    // top right
    var x2 = off2.left+15-(off3.left);
    var y2 = off2.top+((off2.height)/2)-( off3.top);
    // distance
    var length = Math.sqrt(((x2-x1) * (x2-x1)) + ((y2-y1) * (y2-y1)))-23;
    // center
    var cx = ((x1 + x2) / 2) - (length / 2);
    var cy = ((y1 + y2) / 2) - (thickness / 2);
    // angle
    var angle = Math.atan2((y1-y2),(x1-x2))*(180/Math.PI);
    // make hr
    var htmlLine = "<div id='"+div1.id+div2.id+"' class='"+class_name+"' style='padding:0px; margin:0px; height:" + thickness + "px;  " +
        "line-height:1px; position:absolute; z-index:2; left:" + cx + "px; top:" + cy + "px; width:" + length + "px; " +
        "-moz-transform:rotate(" + angle + "deg); -webkit-transform:rotate(" + angle + "deg); -o-transform:rotate(" + angle + "deg); " +
        "-ms-transform:rotate(" + angle + "deg); transform:rotate(" + angle + "deg);' />";
    // alert(htmlLine);
    document.getElementById("OMG").innerHTML+= htmlLine;
}
