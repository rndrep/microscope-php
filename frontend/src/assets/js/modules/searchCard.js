import { param } from "jquery";
import { postData } from "../services/services.js";
import Card from "./card";

export function createCards(urlResource) {
    let tabs = document.querySelectorAll(".tabs__link"),
        cardsWrapper = document.querySelector(".cards"),
        cardsRows = document.querySelectorAll(".cards__row"),
        forms = document.getElementsByTagName("form"),
        statusMessage = document.createElement("div");

    const searchCard = function (form, urlResource) {
        let formData = new FormData(form);

        const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));

        return postData(urlResource, jsonData);
    };

    const createCards = function (data, parantElement) {
        const cards = data.data;

        // TODO: добавить 3д
        cards.forEach(({ photo, name, info_url, microscope_url, model_3d }) => {
            new Card(
                photo,
                name,
                info_url,
                microscope_url,
                model_3d,
                parantElement
            ).render();
        });
    };

    const clearCards = function (selector) {
        while (selector.firstChild) {
            selector.removeChild(selector.firstChild);
        }
    };

    const searchAllCards = function (form, url, parantElement) {
        searchCard(form, url).then((data) => {
            parantElement === cardsRows[0]
                ? parantElement.classList.toggle("active")
                : "";

            createCards(data, parantElement);
        });
    };

    const addTabListener = function (tab) {
        tab.addEventListener("shown.bs.tab", (event) => {
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
                const parantElement = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                clearCards(parantElement);
                createCards(data, parantElement);
            });
        });
    };

    if (cardsWrapper) {
        try {
            for (const form of forms) {
                const url = form.getAttribute("data-url");

                const parantElement = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                searchAllCards(form, url, parantElement);
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
