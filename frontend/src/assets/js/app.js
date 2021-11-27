"use strict";

import $ from "jquery";
import "bootstrap";
import slick from "./modules/slick";
import select from "./modules/select";
import searchCard from "./modules/searchCard";

window.addEventListener("DOMContentLoaded", () => {
    // slick-carousel
    $("#accordion-button-gallery").on("click", function (event) {
        slick();
    });

    select();
    searchCard();
});
