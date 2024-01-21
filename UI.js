window.onload = function () {
    setTimeout(function() {
        insertPageNavigors()
        fadeOutEffect()
        addImageListeners()
		siteTutorial()
    }, 100)

    console.info("https://github.com/Pexeus")

    initBook()
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