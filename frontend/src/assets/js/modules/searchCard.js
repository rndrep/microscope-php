import { param } from "jquery";
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
            searchCard(rocksSearchForm, urlRocks);
            addFormListener(rocksSearchForm, rocksTab, urlRocks);
            addFormListener(mineralsSearchForm, mineralsTab, urlMinerals);
            addFormListener(fossilsSearchForm, fossilsTab, urlFossils);
        } catch (error) {}
    }

    function addFormListener(form, tab, url) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            searchCard(form, url);
        });

        tab.addEventListener("show.bs.tab", () => {
            searchCard(form, url);
        });
    }

    //TODO: отрисовать все карточки породы и минералы при загрузке

    function searchCard(form, urlResource) {
        let formData = new FormData(form);

        const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));
        console.log(jsonData);
        postData(urlResource, jsonData)
            .then(clearCards())
            .then((data) => {
                console.log(data);

                createCards(data);
            })
            .then(() => console.log("Отправлено"))
            .then(() => {
                statusMessage.innerHTML = "Успешно";
            })
            .catch(() => (statusMessage.innerHTML = "Не отправлено"));
    }

    function createCards(data) {
        const cards = data.data;

        cards.forEach(({ photo, name, info_url, microscope_url, model_3d }) => {
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
