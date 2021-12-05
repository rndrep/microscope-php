"use strict";

import $ from "jquery";
import "bootstrap";
import slick from "./modules/slick";
import select from "./modules/select";
import searchCard from "./modules/searchCard";
import createMicroscope from "./modules/createMicroscope";
import map from "./modules/map";

window.addEventListener("DOMContentLoaded", () => {
    const microscopeWrap = document.querySelector(".microscope__wrap"),
        mapWrap = document.querySelector(".map"),
        selectSingle = document.querySelectorAll(".select-single"),
        selectMultiple = document.querySelectorAll(".select-multiple");

    // slick-carousel
    $("#accordion-button-gallery").on("click", function (event) {
        slick();
    });

    searchCard();

    function getUrlParams() {
        let urlSearch = window.location.search;
        let urlParams = {};
        urlSearch = urlSearch.substring(1).split("&");
        for (let i = 0; i < urlSearch.length; i++) {
            let c = urlSearch[i].split("=");
            urlParams[c[0]] = c[1];
        }
        return urlParams;
    }

    if (microscopeWrap) {
        try {
            createMicroscope(
                `http://microscope.test/microscope-photos/${
                    getUrlParams().type
                }/${getUrlParams().id}`
            );
        } catch (error) {}
    }

    if (mapWrap) {
        try {
            map();
        } catch (error) {}
    }

    if (selectSingle.length != 0 || selectMultiple.length != 0) {
        try {
            select();
        } catch (error) {}
    }
});
