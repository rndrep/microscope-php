require("./bootstrap");

require("../assets/ckeditor5/build/ckeditor");

window.addEventListener("DOMContentLoaded", () => {
    ClassicEditor.create(document.querySelector("#descriptionEditor")).catch(
        (error) => {
            console.error(error);
        }
    );
});
