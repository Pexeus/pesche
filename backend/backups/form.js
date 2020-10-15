function setBackup() {
    let current = event.target

    while (current.id == "") {
        current = current.parentElement
    }

    document.getElementById("backupName").value = current.id
}