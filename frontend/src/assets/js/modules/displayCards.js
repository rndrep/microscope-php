import { param } from "jquery";
import { postData } from "../services/services.js";
import Card from "./card";

export function createCards(urlResource) {
    let tabs = document.querySelectorAll(".tabs__link"),
        cardsWrapper = document.querySelector(".cards"),
        cardsRows = document.querySelectorAll(".cards__row"),
        cardContainer = document.querySelector(".cards .container"),
        forms = document.getElementsByTagName("form"),
        messageFail = document.createElement("div"),
        searchMessage = document.createElement("div");

    const searchCard = function (form, urlResource) {
        let formData = new FormData(form);

        const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));

        return postData(urlResource, jsonData);
    };

    const createCards = function (data, parentElement) {
        const cards = data.data;

        // TODO: добавить 3д
        cards.forEach(({ photo, name, info_url, microscope_url, model_3d }) => {
            new Card(
                photo,
                name,
                info_url,
                microscope_url,
                model_3d,
                parentElement
            ).render();
        });
    };

    const clearCards = function (selector) {
        while (selector.firstChild) {
            selector.removeChild(selector.firstChild);
        }
    };

    const searchAllCards = function (form, url, parentElement) {
        searchCard(form, url).then((data) => {
            if (parentElement === cardsRows[0])
                parentElement.classList.toggle("active");

            createCards(data, parentElement);
        });
    };

    const addTabListener = function (tab) {
        tab.addEventListener("shown.bs.tab", (event) => {
            messageFail.innerHTML = ``;
            cardContainer.insertBefore(messageFail, cardsRows[0]);

            document
                .querySelector(event.target.getAttribute("data-card-target"))
                .classList.toggle("active");

            document
                .querySelector(
                    event.relatedTarget.getAttribute("data-card-target")
                )
                .classList.toggle("active");
        });
    };

    const addFormListener = function (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();

            const url = form.getAttribute("data-url");

            searchCard(form, url).then((data) => {
                const parentElement = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                clearCards(parentElement);

                if (data.data.length === 0) {
                    messageFail.innerHTML = `<p class="form-label text-center mb-3">Ничего не найдено</p>`;
                    cardContainer.insertBefore(messageFail, cardsRows[0]);
                } else {
                    messageFail.innerHTML = `<p class="form-label text-center mb-3">Найдено ${data.data.length}</p>`;
                    cardContainer.insertBefore(messageFail, cardsRows[0]);
                }

                createCards(data, parentElement);
            });
        });
    };

    if (cardsWrapper) {
        try {
            for (const form of forms) {
                const url = form.getAttribute("data-url");

                const parentElement = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                searchAllCards(form, url, parentElement);
            }

            tabs.forEach((tab) => {
                addTabListener(tab);
            });

            for (const form of forms) {
                addFormListener(form);
            }
        } catch (error) {}
    }
}

export default createCards;
