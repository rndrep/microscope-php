import { param } from "jquery";
import { getResource } from "../services/services.js";
import { postData } from "../services/services.js";
import Card from "./card";

export function searchCard(urlResource) {
    const urlRocks = "/rock-list";
    const urlMinerals = "/mineral-list";
    const urlFossils = "/fossil-list";

    let rocksTab = document.getElementById("rocksTab"),
        mineralsTab = document.getElementById("mineralsTab"),
        fossilsTab = document.getElementById("fossilsTab"),
        cardsRow = document.querySelector(".cards__row"),
        rocksSearchForm = document.querySelector("#rocksSearchForm"),
        mineralsSearchForm = document.querySelector("#mineralsSearchForm"),
        fossilsSearchForm = document.querySelector("#fossilsSearchForm"),
        statusMessage = document.createElement("div");

    if (cardsRow) {
        try {
            rocksSearchForm.addEventListener("submit", (e) => {
                e.preventDefault();

                searchCard(rocksSearchForm, urlRocks);
            });
        } catch (error) {}
    }

    if (cardsRow) {
        try {
            rocksTab.addEventListener("show.bs.tab", () => {
                searchCard(rocksSearchForm, urlRocks);
            });
        } catch (error) {}
    }
    //TODO: отрисовать все карточки породы и минералы

    function searchCard(form, urlResource) {
        let formData = new FormData(form);

        const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));

        postData(urlResource, jsonData)
            .then((data) => {
                createCards(data);
            })
            .then(() => console.log("Отправлено"))
            .then(() => {
                statusMessage.innerHTML = "успешно";
            })
            .catch(() => (statusMessage.innerHTML = "не получилось"));
    }

    function createCards(data) {
        clearCards();
        const cards = data.data;
        console.log(cards);
        cards.forEach(({ photo, name, info_url, microscope_url, model_3d }) => {
            //new card
            // TODO: добавить 3д ссылку
            new Card(photo, name, info_url, microscope_url).render();
        });
    }

    function clearCards() {
        while (cardsRow.firstChild) {
            cardsRow.removeChild(cardsRow.firstChild);
        }
    }

    // mineralsTab.addEventListener("show.bs.tab", () => {
    //     searchCard(mineralsSearchForm, urlMinerals);
    // });

    // после нажатия кнопки поиск с id порода/минерал/окаменелость
    // отправить форму методом пост
    // получить ответ
    // отрисоватьь нужные карточки на странице
}

export default searchCard;
