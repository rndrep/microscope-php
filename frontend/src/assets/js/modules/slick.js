import $ from "jquery";
import "slick-carousel";

export function slick() {
    let gallery = $("#gallery");

    gallery.not(".slick-initialized").slick({
        // normal options...
        arrows: false,
        dots: true,
        speed: 800,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        adaptiveHeight: true,
        centerMode: true,
    });

    $("#gallery-arrow-prev").on("click", function (event) {
        event.preventDefault();
        gallery.slick("slickPrev");
    });

    $("#gallery-arrow-next").on("click", function (event) {
        event.preventDefault();
        gallery.slick("slickNext");
    });
}

export default slick;
