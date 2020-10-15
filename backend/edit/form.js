function loadFile(event) {
    var output = document.getElementById('preview_' + event.target.name)
    output.src = URL.createObjectURL(event.target.files[0])


    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
};

function toggleDelete() {
  let input = event.target.parentNode.childNodes[1].childNodes[2]
  let image = event.target.parentNode.childNodes[3]
  let button = event.target

  if (input.value == "false") {
    input.value = "true"
    image.style.display = "none"
    button.innerHTML = "Rückgängig machen"
  }
  else {
    input.value = "false"
    image.style.display = "inline-block"
    button.innerHTML = "Löschen"
  }
}