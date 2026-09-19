var progressDone = false

document.addEventListener("DOMContentLoaded", function () {
    initProgress()
})

window.onload = function () {
    setTimeout(function() {
        insertPageNavigors()
        finishProgress()
        addImageListeners()
		siteTutorial()
    }, 100)

    console.info("https://github.com/Pexeus")

    initBook()
}

function initProgress() {
    const bar = document.getElementById("progressBar")
    if (!bar) {
        return
    }

    const text = document.getElementById("progressText")

    const images = Array.from(document.images)
    const videos = Array.from(document.querySelectorAll("video"))
    const assets = images.concat(videos)
    const total = assets.length

    if (total === 0) {
        finishProgress()
        return
    }

    let loaded = 0

    const update = () => {
        const pct = Math.round((loaded / total) * 100)
        bar.style.width = pct + "%"
        if (text) {
            text.innerHTML = loaded + " / " + total
        }
    }

    const onLoad = () => {
        loaded++
        update()
        if (loaded >= total) {
            finishProgress()
        }
    }

    update()

    assets.forEach(asset => {
        if (asset.tagName === "IMG") {
            if (asset.complete) {
                onLoad()
            } else {
                asset.addEventListener("load", onLoad, { once: true })
                asset.addEventListener("error", onLoad, { once: true })
            }
        } else {
            if (asset.readyState >= 1) {
                onLoad()
            } else {
                asset.addEventListener("loadedmetadata", onLoad, { once: true })
                asset.addEventListener("error", onLoad, { once: true })
            }
        }
    })
}

function finishProgress() {
    if (progressDone) {
        return
    }
    progressDone = true

    const bar = document.getElementById("progressBar")
    if (bar) {
        bar.style.width = "100%"
    }

    const text = document.getElementById("progressText")
    if (text) {
        text.innerHTML = "100%"
    }

    fadeOutEffect()
}

function siteTutorial() {
	
}

function scrollTo(element) {
    console.log(element.childNodes[1].childNodes[1].innerHTML)
    element.scrollIntoView({
        behavior: 'auto',
        block: 'center',
        inline: 'center'
    });
}


function fadeOutEffect() {
    var fadeTarget = document.getElementById("welcome");
    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.02;
        }
        else {
            fadeTarget.style.display = "none"
        }
    }, 10);
}