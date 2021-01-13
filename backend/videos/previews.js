function loadFile(event) {
    console.log('preview_' + event.target.name);
    var output = document.getElementById('preview_' + event.target.name)
    output.src = URL.createObjectURL(event.target.files[0])
    document.getElementsByClassName("preview")[0].style.display = "block"


    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
};