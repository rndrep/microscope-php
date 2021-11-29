import { getResource } from "../services/services.js";
import { postData } from "../services/services.js";
import select from "./select";

export function searchCard(urlResource) {
    const url = "/rock-list";
    let rocksSearchBtn = document.getElementById("rocksSearchBtn");
    let mineralsSearchBtn = document.getElementById("mineralsSearchBtn");
    let fossilsSearchBtn = document.getElementById("fossilsSearchBtn");

    let rocksSearchForm = document.querySelector("#rocksSearchForm"),
        mineralsSearchForm = document.querySelector("#mineralsSearchForm"),
        fossilsSearchForm = document.querySelector("#fossilsSearchForm"),
        statusMessage = document.createElement("div");

    statusMessage.classList.add("status");

    window.addEventListener("DOMContentLoaded", () => {
        // отобразить все карточки пород на вкладке пород
    });

    sendForm(rocksSearchForm, url);

    function sendForm(form, urlResource) {
        form.addEventListener("submit", function (event) {
            let formData = new FormData(form);
            console.log(...formData);

            event.preventDefault();

            const object = {};
            formData.forEach(function (value, key) {
                object[key] = value;
            });

            console.log(object);

            postData(object, urlResource)
                .then((data) => data.text())
                .then((data) => console.log(data))
                .then(() => (statusMessage.innerHTML = "запрос отправлен"))
                .then(() => {
                    statusMessage.innerHTML = "успешно";
                })
                .catch(() => (statusMessage.innerHTML = "не получилось"));
        });
    }

    // после нажатия кнопки поиск с id порода/минерал/окаменелость
    // отправить форму методом пост
    // получить ответ
    // отрисоватьь нужные карточки на странице
}

export default searchCard;
