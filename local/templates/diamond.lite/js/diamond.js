$(document).ready(function () {

    /**
     * Social user carusel
     */
    $("#social-user-list").jCarouselLite({
        auto: 3000,
        speed: 1000,
        btnNext: "#social-user-list-container .carousel-next",
        btnPrev: "#social-user-list-container .carousel-prev",
        visible: 6
    });

    /**
     * Timer for Touch event
     */
    toucHendTimer = false;

    setTimeout(function () {
        // set vk.com lib to header
        var script = document.createElement('script');
        script.src = "https://vk.com/js/api/openapi.js";
        document.getElementsByTagName('head')[0].appendChild(script);

        console.info("vk api");

    }, 6000);
});

/**
 * @param t
 * @returns {boolean}
 */
function touchstartLink(t) {
    toucHendTimer = setTimeout(function () {
        location.href = t.href;
    },300);
    return true;
}

/**
 *
 * @returns {boolean}
 */
function touchendLink() {
    clearTimeout(toucHendTimer);
    return true;
}
