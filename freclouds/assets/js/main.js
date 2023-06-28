function share(getid){
    var input = document.createElement("input");
    input.type = "text";
    var link = document.getElementById(getid).innerHTML;
    input.value = link;
    document.body.appendChild(input);
    input.select();
    document.execCommand("copy");
    input.remove();
    alert("link copied sucessfuly");
}