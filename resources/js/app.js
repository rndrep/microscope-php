import "bootstrap";
import initDropzone from "./dropzone";
import ckeditor from "../assets/ckeditor5/build/ckeditor";
import adminLte from "../../node_modules/admin-lte/build/js/AdminLTE";

window.addEventListener("DOMContentLoaded", () => {
    let editorList = document.querySelectorAll(".editor");
    if (editorList.length != 0) {
        editorList.forEach((element) => {
            if (element) {
                InlineEditor.create(element).catch((error) => {
                    console.error(error);
                });
            }
        });
    }

    initDropzone();
    // if()initDropzone()
});
