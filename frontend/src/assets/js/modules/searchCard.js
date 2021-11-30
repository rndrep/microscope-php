import { getResource } from "../services/services.js";
import { postData } from "../services/services.js";
import Card from "./card";

export function searchCard(urlResource) {
    const url = "/rock-list";
    let rocksSearchBtn = document.getElementById("rocksSearchBtn"),
        mineralsSearchBtn = document.getElementById("mineralsSearchBtn"),
        fossilsSearchBtn = document.getElementById("fossilsSearchBtn"),
        cardsRow = document.querySelector(".cards__row");

    let rocksSearchForm = document.querySelector("#rocksSearchForm"),
        mineralsSearchForm = document.querySelector("#mineralsSearchForm"),
        fossilsSearchForm = document.querySelector("#fossilsSearchForm"),
        statusMessage = document.createElement("div");

    statusMessage.classList.add("status");

    //получить все карточки
    getResource(url)
        // TODO: отрисовать все
        .then((data) => {
            const cards = data.data;
            cards.forEach(
                ({ photo, name, info_url, microscope_url, model_3d }) => {
                    //new card
                    // TODO: добавить 3д ссылку
                    new Card(photo, name, info_url, microscope_url).render();
                }
            );
        });

    rocksSearchBtn.addEventListener("click", function (e) {
        sendForm(rocksSearchForm, url);
    });

    mineralsSearchBtn.addEventListener("click", function (e) {
        sendForm(mineralsSearchForm, url);
    });

    fossilsSearchBtn.addEventListener("click", function (e) {
        sendForm(fossilsSearchForm, url);
    });

    function sendForm(form, urlResource) {
        form.addEventListener("submit", function (event) {
            let formData = new FormData(form);

            event.preventDefault();

            const jsonData = JSON.stringify(
                Object.fromEntries(formData.entries())
            );

            postData(urlResource, jsonData)
                .then((data) => {
                    clearCards();
                    const cards = data.data;
                    cards.forEach(
                        ({
                            photo,
                            name,
                            info_url,
                            microscope_url,
                            model_3d,
                        }) => {
                            //new card
                            // TODO: добавить 3д ссылку
                            new Card(
                                photo,
                                name,
                                info_url,
                                microscope_url
                            ).render();
                        }
                    );
                })
                .then(() => console.log("Отправлено"))
                .then(() => {
                    statusMessage.innerHTML = "успешно";
                })
                .catch(() => (statusMessage.innerHTML = "не получилось"));
        });
    }

    function clearCards() {
        while (cardsRow.firstChild) {
            cardsRow.removeChild(cardsRow.firstChild);
        }
    }

    // после нажатия кнопки поиск с id порода/минерал/окаменелость
    // отправить форму методом пост
    // получить ответ
    // отрисоватьь нужные карточки на странице
}

export default searchCard;
