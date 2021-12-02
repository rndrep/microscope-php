require("./bootstrap");

require("../assets/ckeditor5/build/ckeditor");

window.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".editor").forEach((element) => {
        if (element) {
            ClassicEditor.create(element).catch((error) => {
                console.error(error);
            });
        }
    });
});
