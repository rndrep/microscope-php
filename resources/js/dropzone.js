import Dropzone from "../../node_modules/dropzone";

export function initDropzone() {
    const photoField = document.querySelector("#photoDropzone"),
        galleryField = document.querySelector("#galleryDropzone"),
        microField = document.querySelector(".microDropzone");

    if (photoField) {
        try {
            const photoDropzone = new Dropzone(photoField, {
                url: "http://microscope.test/admin/minerals/1",
                uploadMultiple: false,
                maxFiles: 1,
                maxFilesize: 1, // Max filesize in MB
                addRemoveLinks: true,
                dictRemoveFile: "×",
            });

            photoDropzone.on("addedfile", (file) => {
                console.log(`File added: ${file.name}`);
            });

            photoDropzone.on("error", (file, error) => {
                const elements = document.querySelectorAll(".dz-file-preview");

                for (const element of elements) {
                    const filename =
                        element.querySelectorAll(".dz-filename span")[0]
                            .textContent;
                    const errorMessage = element.querySelectorAll(
                        ".dz-error-message span"
                    )[0];
                    if (filename === file.name) {
                        errorMessage.textContent =
                            "Нельзя загрузить больше одного файла";
                    }
                }
            });
        } catch (error) {}
    }

    if (galleryField) {
        try {
            const galleryDropzone = new Dropzone(galleryField, {
                url: "http://microscope.test/admin/minerals/1",
                method: "put",
                uploadMultiple: false,
                maxFiles: 5,
                maxFilesize: 1, // Max filesize in MB
                parallelUploads: 2,
                addRemoveLinks: true,
                dictRemoveFile: "×",
                removedfile: function (file) {
                    // удаление только что загруженных
                    file.previewElement.remove();
                },
            });

            galleryDropzone.on("addedfile", function (file) {
                galleryField.querySelector(
                    ".dropzone-remove-all"
                ).style.display = "inline-block";
            });

            // Setup the button for remove all files
            galleryField
                .querySelector(".dropzone-remove-all")
                .addEventListener("click", function () {
                    galleryField.querySelector(
                        ".dropzone-remove-all"
                    ).style.display = "none";
                    galleryDropzone.removeAllFiles(true);
                });

            // On all files removed
            galleryDropzone.on("removedfile", function (file) {
                if (galleryDropzone.files.length < 1) {
                    galleryField.querySelector(
                        ".dropzone-remove-all"
                    ).style.display = "none";
                }
            });
        } catch (error) {}
    }

    if (microField) {
        try {
            document.querySelectorAll(".microDropzone").forEach((element) => {
                new Dropzone(element, {
                    url: "http://microscope.test/admin/minerals/1",
                    method: "put",
                    uploadMultiple: false,
                    maxFiles: 5,
                    maxFilesize: 1, // Max filesize in MB
                    parallelUploads: 2,
                    addRemoveLinks: true,
                    dictRemoveFile: "×",
                    previewsContainer: ".microDropzone" + " .dropzone-items",
                    removedfile: function (file) {
                        // удаление только что загруженных
                        file.previewElement.remove();
                    },
                });
            });
        } catch (error) {}
    }
}

export default initDropzone;
