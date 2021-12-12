import "bootstrap";
import $ from "jquery";
import "../../node_modules/admin-lte/plugins/select2/js/select2";
import "./select-ru";
import initDropzone from "./dropzone";
import "../assets/ckeditor5/build/ckeditor";
import "../sass/ckeditor.scss";
import adminLte from "../../node_modules/admin-lte/build/js/AdminLTE";
import "../../node_modules/admin-lte/plugins/datatables/jquery.dataTables.min";
import "../../node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min";
import "../../node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min";
import "../../node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min";
import "../../node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min";
import "../../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min";
import "../../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min";

window.addEventListener("DOMContentLoaded", () => {
    const editors = document.querySelectorAll(".editor"),
        dataTable = document.getElementById("dataTable");

    if (dataTable) {
        try {
            $("#dataTable").DataTable({
                dom: `<"table__search"f><"table__length-menu"l>t<"table__info"i><"table__pagination"p>`,
                stateSave: true,
                responsive: true,

                buttons: ["colvis"],
                language: {
                    lengthMenu: "Показывать _MENU_ записей на странице",
                    zeroRecords: "Ничего не найдено",
                    info: "Страница _PAGE_ из _PAGES_",
                    search: "Поиск",
                    infoEmpty: "Нет записей",
                    paginate: {
                        previous: "Предыдущая",
                        next: "Следующая",
                    },
                },
            });
        } catch (error) {}
    }

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
});
