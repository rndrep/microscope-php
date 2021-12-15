import "../../node_modules/admin-lte/plugins/datatables/jquery.dataTables.min";
import "../../node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min";
import "../../node_modules/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min";
import "../../node_modules/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min";
import "../../node_modules/admin-lte/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min";
import "../../node_modules/admin-lte/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min";
// import "../../node_modules/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min";
// import "../../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min";
// import "../../node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.min";

export function initTable() {
    const dataTable = document.getElementById("dataTable");

    if (dataTable) {
        try {
            const table = new DataTable("#dataTable", {
                autoWidth: true,
                stateSave: true,
                dom: `<"table__search"f><"table__length-menu"l>t<"table__info"i><"table__pagination"p>`,

                responsive: {
                    details: {
                        type: "column",
                        target: document.getElementById("#dataTable"),
                    },
                },
                columnDefs: [
                    {
                        className: "dtr-control",
                        targets: document.getElementById("#dataTable"),
                    },
                    { orderable: false, targets: [0, 3] },
                ],

                // sScrollY: 0.4 * $(window).height(),
                // sScrollX: "100%",
                // bScrollCollapse: true,
                // sScrollXInner: "110%",
                fixedHeader: true,

                language: {
                    lengthMenu: "Показывать _MENU_ записей на странице",
                    zeroRecords: "Ничего не найдено",
                    info: "Страница _PAGE_ из _PAGES_",
                    search: "Поиск",
                    infoEmpty: "Нет записей",
                    infoFiltered: " ",
                    paginate: {
                        previous: "Предыдущая",
                        next: "Следующая",
                    },
                },
            });
        } catch (error) {}
    }
}
export default initTable;
