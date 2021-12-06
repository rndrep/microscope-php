import Dropzone from "../../node_modules/dropzone";

export function initDropzone() {
    const photoField = document.querySelector("#photoDropzone"),
        galleryField = document.querySelector("#galleryDropzone"),
        microField = document.querySelector("#microPplDropzone");

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
            createMicroDropzone("#microPplDropzone");
            createMicroDropzone("#microXplDropzone");
        } catch (error) {}
    }

    function createMicroDropzone(id) {
        const dropzone = document.querySelector(id);

        // set the preview element template
        let previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        let previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        const myDropzone = new Dropzone(id, {
            // Make the whole body a dropzone
            url: "http://microscope.test/", // Set the url for your upload script location
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            maxFiles: 36,
            maxFilesize: 1, // Max filesize in MB
            dictFileTooBig:
                "Файл слишком большой ({{filesize}}MB). Максимальный размер: {{maxFilesize}}MB.",
            dictMaxFilesExceeded: "Вы не можете загрузить больше файлов",
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
        });

        myDropzone.on("addedfile", function (file) {
            const dropzoneItems = dropzone.querySelectorAll(".dropzone-item");
            dropzoneItems.forEach((dropzoneItem) => {
                dropzoneItem.style.display = "";
            });
            dropzone.querySelector(".dropzone-upload").style.display =
                "inline-block";
            dropzone.querySelector(".dropzone-remove-all").style.display =
                "inline-block";
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function (progress) {
            const progressBars = dropzone.querySelectorAll(".progress-bar");
            progressBars.forEach((progressBar) => {
                progressBar.style.width = progress + "%";
            });
        });

        myDropzone.on("sending", function (file) {
            // Show the total progress bar when upload starts
            const progressBars = dropzone.querySelectorAll(".progress-bar");
            progressBars.forEach((progressBar) => {
                progressBar.style.opacity = "1";
            });
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("complete", function (progress) {
            const progressBars = dropzone.querySelectorAll(".dz-complete");

            setTimeout(function () {
                progressBars.forEach((progressBar) => {
                    progressBar.querySelector(".progress-bar").style.opacity =
                        "0";
                    progressBar.querySelector(".progress").style.opacity = "0";
                });
            }, 300);
        });

        // Setup the buttons for all transfers
        dropzone
            .querySelector(".dropzone-upload")
            .addEventListener("click", function () {
                myDropzone.enqueueFiles(
                    myDropzone.getFilesWithStatus(Dropzone.ADDED)
                );
            });

        // Setup the button for remove all files
        dropzone
            .querySelector(".dropzone-remove-all")
            .addEventListener("click", function () {
                dropzone.querySelector(".dropzone-upload").style.display =
                    "none";
                dropzone.querySelector(".dropzone-remove-all").style.display =
                    "none";
                myDropzone.removeAllFiles(true);
            });

        // On all files completed upload
        myDropzone.on("queuecomplete", function (progress) {
            const uploadIcons = dropzone.querySelectorAll(".dropzone-upload");
            uploadIcons.forEach((uploadIcon) => {
                uploadIcon.style.display = "none";
            });
        });

        // On all files removed
        myDropzone.on("removedfile", function (file) {
            if (myDropzone.files.length < 1) {
                dropzone.querySelector(".dropzone-upload").style.display =
                    "none";
                dropzone.querySelector(".dropzone-remove-all").style.display =
                    "none";
            }
        });
    }
}

export default initDropzone;
