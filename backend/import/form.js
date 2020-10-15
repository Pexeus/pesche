function setImport() {
    let path = event.target.id

    if (path == "") {
        path = event.target.parentNode.id
    }

    document.getElementById("importPath").value = path
    document.getElementById("displayPath").innerHTML = "Ausgewählt: " + path
}