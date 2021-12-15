import "bootstrap";
import $ from "jquery";
window.$ = $;
import {
    ControlSidebar,
    Dropdown,
    ExpandableTable,
    Layout,
} from "../../node_modules/admin-lte/build/js/AdminLTE";
import "../../node_modules/admin-lte/plugins/select2/js/select2";
import "./select-ru";
import "../assets/ckeditor5/build/ckeditor";
import "../sass/ckeditor.scss";
import initDropzone from "./dropzone";
import initMap from "./map";
import initTable from "./table";

window.addEventListener("DOMContentLoaded", () => {
    const editors = document.querySelectorAll(".editor"),
        dataTable = document.getElementById("dataTable");

    if ($(".select2")) {
        try {
            $(".select2").select2({
                theme: "bootstrap4",
                width: "100%",
                language: "ru",
            });
        } catch (error) {}
    }

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

    initTable();

    initMap();

    initDropzone();
});
