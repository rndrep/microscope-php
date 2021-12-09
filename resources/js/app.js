import "bootstrap";
import $ from "jquery";
import "../../node_modules/admin-lte/plugins/select2/js/select2";
import "./select-ru";
import initDropzone from "./dropzone";
import "../assets/ckeditor5/build/ckeditor";
import "../sass/ckeditor.scss";
import adminLte from "../../node_modules/admin-lte/build/js/AdminLTE";

window.addEventListener("DOMContentLoaded", () => {
    const editors = document.querySelectorAll(".editor");
    // adminSelects = document.querySelectorAll(".select2");

    if ($(".select2")) {
        try {
            $(".select2").select2({
                theme: "bootstrap4",
                width: "100%",
                language: "ru",
            });
        } catch (error) {}
    }

    // $('.js-example-basic-multiple').select2();

    // console.log(adminSelects);
    // adminSelects.forEach((element) => {
    //     element.select2();
    // });
    // adminSelects.select2();

    if (editors.length != 0) {
        editors.forEach((element) => {
            ClassicEditor.create(element)
                .catch((error) => {
                    console.error(error);
                })
                .then((editor) => {
                    window.editor = editor;
                    let myEditor = editor;
                    // TODO: в каком-то элементе нет value??
                    if (element.getAttribute("value")) {
                        myEditor.setData(element.getAttribute("value"));
                    }
                });
        });
    }

    initDropzone();
    // if()initDropzone()

    let navbar = document.querySelector(".nav-link");

    if (localStorage.getItem("sidebar-collapse") === "true") {
        document
            .querySelector(".sidebar-mini")
            .classList.add("sidebar-collapse");
    }

    let isOpen = localStorage.getItem("sidebar-collapse");

    // localStorage.setItem("sidebar-collapse", isOpen);
});
