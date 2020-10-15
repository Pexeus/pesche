function loadFile(event) {
    var output = document.getElementById('preview_' + event.target.name)
    output.src = URL.createObjectURL(event.target.files[0])


    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
};