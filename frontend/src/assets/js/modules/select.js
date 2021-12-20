import SlimSelect from "slim-select";
import { getResource } from "../services/services.js";

export function select() {
    let slimSelects = {};
    document.querySelectorAll(".select-single").forEach((element) => {
        let entity = element.getAttribute('name');
        let slimSelect = new SlimSelect({
            select: element,
            searchPlaceholder: "Поиск",
            showSearch: "false",
            searchText: "Не найдено",
            selected: false,
            placeholder: "-",
            deselectLabel: " ",
            allowDeselect: true,
        });
        slimSelects[entity] = slimSelect
    });

    slimSelects['rockType'].onChange = function () {
        getResource('/match-dict?entity=RockType&id=' + this.selected())
        .then((data) => {
            slimSelects['rockClass'].setData(data);
            slimSelects['rockClass'].set([]);
        })
        .then(() => {
            let crossElement = slimSelects['rockClass'].slim.singleSelected.deselect;
            crossElement.classList.add('ss-hide');
            crossElement.addEventListener('click', function (e) {
                slimSelects['rockClass'].set([]);
                this.classList.add('ss-hide');
            });
        });
    };

    slimSelects['rockClass'].onChange = function () {
        getResource('/match-dict?entity=RockClass&id=' + this.selected())
            .then((data) => {
                slimSelects['rockKind'].setData(data);
                slimSelects['rockKind'].set([]);
            })
            .then(() => {
                let crossElement = slimSelects['rockKind'].slim.singleSelected.deselect;
                crossElement.classList.add('ss-hide');
                crossElement.addEventListener('click', function (e) {
                    slimSelects['rockKind'].set([]);
                    this.classList.add('ss-hide');
                });
            });
    };

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
