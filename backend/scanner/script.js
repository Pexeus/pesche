const entries = []

function init() {
    document.getElementById("searchInput").value =""

    const entriesRaw = document.querySelectorAll("tr")
    
    entriesRaw.forEach(entry => {
        if (!entry.innerHTML.includes("<th")) {
            entries.push(entry)
        }
    })
}

function search() {
    const query = event.target.value.toLocaleLowerCase()

    if (query == "") {
        entries.forEach(entry => {
            entry.style.display = "table-row"
        })
    }
    else {
        entries.forEach(entry => {
            if (entry.innerHTML.toLocaleLowerCase().includes(query)) {
                entry.style.display = "table-row"
            }
            else {
                entry.style.display = "none"
            }
        })
    }
    
}

init()