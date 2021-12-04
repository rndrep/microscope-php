import "bootstrap";
import initDropzone from "./dropzone";
import ckeditor from "../assets/ckeditor5/build/ckeditor";

window.addEventListener("DOMContentLoaded", () => {
    let editorList = document.querySelectorAll(".editor");
    if (editorList.length != 0) {
        editorList.forEach((element) => {
            if (element) {
                ClassicEditor.create(element).catch((error) => {
                    console.error(error);
                });
            }
        });
    }

    initDropzone();
    // if()initDropzone()
});
