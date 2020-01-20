function handleToggleChanged(e){
    var toggleState=(this.classList.contains('toggle-yes'))?1:0;
    var Handler =
        function(Request){

        }
    SendRequest("/j/p/z/asssessment/state/"+this.id+"/"+toggleState,Handler);
}
var toggleElements = document.querySelectorAll('.toggle-no,.toggle-yes');
[].forEach.call(toggleElements, function(_toggle){
    _toggle.addEventListener('click', handleToggleChanged, false);
});