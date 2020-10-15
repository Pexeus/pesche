function toggleCategory() {
    catContainer = event.target

    while (catContainer.className != "category") {
        catContainer = catContainer.parentElement
    }

    console.log(catContainer)

    if (catContainer.style.height != "23px") {
        catContainer.style.height = "23px"
    }
    else {
        catContainer.style.height = ""
    }
}

function initLoaders() {
    inputs = document.querySelectorAll("form")

    for (i = 0; i < inputs.length; i++) {
        if (inputs[i].id != "excludeLoader") {
            inputs[i].addEventListener('submit', function(evt){
                toggleLoader(true)
            })
        }
    }
}

function toggleLoader(state) {
    loader = document.getElementById("loaderWrapper")
    body = document.getElementsByTagName("body")[0]


    if (state == true) {
        body.style.overflow = "hidden"
        body.style.height = "100%"

        loader.style.display = "block"

        setTimeout(() => {
            loader.style.opacity = 1
        }, 50);
    }
    else{
        body.style.overflow = ""
        body.style.height = ""

        loader.style.display = "none"
    }
}

initLoaders()