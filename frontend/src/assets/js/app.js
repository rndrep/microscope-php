"use strict";

import $ from "jquery";
import "bootstrap";
import slick from "./modules/slick";
import select from "./modules/select";
import searchCard from "./modules/searchCard";
import createMicroscope from "./modules/createMicroscope";

window.addEventListener("DOMContentLoaded", () => {
    // slick-carousel
    $("#accordion-button-gallery").on("click", function (event) {
        slick();
    });

    select();
    searchCard();

    let getUrlParams = () => {
        let urlSearch = window.location.search;
        let urlParams = {};
        urlSearch = urlSearch.substring(1).split("&");
        for (let i = 0; i < urlSearch.length; i++) {
            let c = urlSearch[i].split("=");
            urlParams[c[0]] = c[1];
        }
        return urlParams;
    };

    createMicroscope(
        `http://microscope.test/microscope-photos/${getUrlParams().type}/${
            getUrlParams().id
        }`
    );
});
