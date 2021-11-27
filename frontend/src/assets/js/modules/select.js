import SlimSelect from "slim-select";

export function select() {
    document.querySelectorAll(".select-single").forEach((element) => {
        new SlimSelect({
            select: element,
            searchPlaceholder: "Поиск",
            showSearch: "false",
            searchText: "Не найдено",
            selected: false,
            placeholder: "-",
            deselectLabel: " ",
            allowDeselect: true,
        });
    });

    document.querySelectorAll(".select-multiply").forEach((element) => {
        const multiplySelects = new SlimSelect({
            select: element,
            showContent: "auto",
            limit: false,
            searchPlaceholder: "Поиск",
            showSearch: "false",
            searchText: "Не найдено",
            placeholder: "-",
            deselectLabel: "×",
            allowDeselect: true,
            hideSelectedOption: true,
            closeOnSelect: false,
        });
    });
}

export default select;
