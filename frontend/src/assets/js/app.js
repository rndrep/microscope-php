"use strict";

import $ from "jquery";
import "bootstrap";
import slick from "./modules/slick";
import select from "./modules/select";
import createCards from "./modules/searchCard";
import createMicroscope from "./modules/createMicroscope";
import initMap from "./modules/map";

window.addEventListener("DOMContentLoaded", () => {
    const microscopeWrap = document.querySelector(".microscope__wrap"),
        selectSingle = document.querySelectorAll(".select-single"),
        selectMultiple = document.querySelectorAll(".select-multiple"),
        searchBtn = document.querySelector("#searchBtn"),
        mapBtn = document.querySelector("#mapBtn");

    (function () {
        if ((searchBtn && mapBtn) != undefined) {
            let currentUrl = window.location;
            if (currentUrl.pathname === "/") {
                searchBtn.setAttribute("href", "#search");
                mapBtn.setAttribute("href", "/map#map");
            } else if (currentUrl.pathname === "/map") {
                searchBtn.setAttribute("href", "/#search");
                mapBtn.setAttribute("href", "#map");
            }
        }
    })();

    // slick-carousel
    $("#accordion-button-gallery").on("click", function (event) {
        slick();
    });

    createCards();

    function getUrlParams() {
        let searchUrl = window.location.search;
        let urlParams = {};
        searchUrl = searchUrl.substring(1).split("&");
        for (let i = 0; i < searchUrl.length; i++) {
            let c = searchUrl[i].split("=");
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

    initMap();

    if (selectSingle.length != 0 || selectMultiple.length != 0) {
        try {
            select();
        } catch (error) {}
    }
});
