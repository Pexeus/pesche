function playVideo() {
    console.log(event.target);

    const video = event.target

    if (video.mozRequestFullScreen) {
        video.mozRequestFullScreen();
    } else if (video.webkitRequestFullScreen) {
        video.webkitRequestFullScreen();
    }

    video.play()
}