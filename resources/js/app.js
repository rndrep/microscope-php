import "bootstrap";
import initDropzone from "./dropzone";
import ckeditor from "../assets/ckeditor5/build/ckeditor";
import adminLte from "../../node_modules/admin-lte/build/js/AdminLTE";

window.addEventListener("DOMContentLoaded", () => {
    const editors = document.querySelectorAll(".editor");
    if (editors.length != 0) {
        editors.forEach((element) => {
            ClassicEditor.create(element)
                .catch((error) => {
                    console.error(error);
                })
                .then((editor) => {
                    window.editor = editor;
                    let myEditor = editor;
                    myEditor.setData(element.getAttribute("value"));
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
