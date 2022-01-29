"use strict";

import $ from "jquery";
import "bootstrap";
import slick from "./modules/slick";
import select from "./modules/select";
import displayCards from "./modules/displayCards";
import createMicroscope from "./modules/createMicroscope";
import initMap from "./modules/initMap";

window.addEventListener("DOMContentLoaded", () => {
    const microscopeWrap = document.querySelector(".microscope__wrap"),
        selectSingle = document.querySelectorAll(".select-single"),
        selectMultiple = document.querySelectorAll(".select-multiple"),
        searchBtn = document.querySelector("#searchBtn"),
        mapBtn = document.querySelector("#mapBtn");

    (function () {
        if ((searchBtn && mapBtn) !== undefined) {
            let currentUrl = window.location;
            if (currentUrl.pathname === "/") {
                searchBtn.setAttribute("href", "#search");
                searchBtn.classList.add("btn_active");
                mapBtn.setAttribute("href", "/map#searchMap");
                mapBtn.addEventListener("mouseenter", function (event) {
                    searchBtn.className = "btn btn_intro ";
                });
                mapBtn.addEventListener("mouseout", function (event) {
                    searchBtn.className = "btn btn_intro btn_active";
                });
            } else if (currentUrl.pathname === "/map") {
                searchBtn.setAttribute("href", "/#search");
                mapBtn.setAttribute("href", "#searchMap");
                mapBtn.classList.add("btn_active");
                searchBtn.addEventListener("mouseenter", function (event) {
                    mapBtn.className = "btn btn_intro ";
                });
                searchBtn.addEventListener("mouseout", function (event) {
                    mapBtn.className = "btn btn_intro btn_active";
                });
            }
        }
    })();

    // slick-carousel
    $("#accordion-button-gallery").on("click", function (event) {
        slick();
    });

    displayCards();

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
                `/microscope-photos/${getUrlParams().type}/${getUrlParams().id}`
            );
        } catch (error) {}
    }

    initMap();

    $("#accordion-button-map").on("click", function (event) {
        initMap();
    });

    if (selectSingle.length != 0 || selectMultiple.length != 0) {
        try {
            select();
        } catch (error) {}
    }
});
