"use strict";

import $ from "jquery";
import "bootstrap";

import map from "./modules/map";
import microscope from "./modules/microscope";
import slick from "./modules/slick";
import select from "./modules/select";

window.addEventListener("DOMContentLoaded", () => {
	// slick-carousel
	$("#accordion-button-gallery").on("click", function (event) {
		slick();
	});

	// leaflet map
	$("#accordion-button-map").on("click", function (event) {
		map();
	});

	select();
	microscope("http://vmicro.tpu.ru/microscope/rock/test");
});

export default microscope;
