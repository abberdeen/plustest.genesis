var startPoint = null;
var endPoint = null;

function handleDragStart(e) {
    this.style.opacity = '0.4';  // this / e.target is the source node.
    startPoint=this.id;
    endPoint = null;
}

function handleDragOver(e) {
    endPoint = null;
    if (e.preventDefault) {
        e.preventDefault(); // Necessary. Allows us to drop.
    }
    //if(getSide(this.id)!=getSide(startPoint) ){
        this.classList.add('over');
    //}
    e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
    return false;
}

function handleDragEnter(e) {
    // this / e.target is the current hover target.
    endPoint = null;
}

function handleDragLeave(e) {
    endPoint=null;
    this.classList.remove('over');  // this / e.target is previous target element.
    //Refresh();
}

function handleDrop(e) {
    // this / e.target is current target element.
    if (e.stopPropagation) {
        e.stopPropagation(); // stops the browser from redirecting.
    }
    endPoint=this.id;
    // See the section on the DataTransfer object.
    return false;
}

function handleDragEnd(e) {
    // this/e.target is the source node.
    [].forEach.call(cols, function (col) {
        col.classList.remove('over');
    });
    this.style.opacity = '1';
    Refresh(startPoint,endPoint);
}

var cols = document.querySelectorAll('#left .column, #right .column');
DNDAddEventListener();

function DNDAddEventListener(){
    cols = document.querySelectorAll('#left .column, #right .column');
    [].forEach.call(cols, function(col) {
        DNDAddEventListeners(col);
    });
}

function  DNDAddEventListeners(e){
    e.addEventListener('dragstart', handleDragStart, false);
    e.addEventListener('dragenter', handleDragEnter, false);
    e.addEventListener('dragover', handleDragOver, false);
    e.addEventListener('dragleave', handleDragLeave, false);
    e.addEventListener('drop', handleDrop, false);
    e.addEventListener('dragend', handleDragEnd, false);
}

