import { param } from "jquery";
import { postData } from "../services/services.js";
import { getResource } from "../services/services.js";
import Card from "./card";
import searchCards from "./searchCards";
import renderCards from "./renderCards";
import PaginationButton from "./pagination";
import clearElements from "./clearElements";

export function displayCards() {
    const tabs = document.querySelectorAll(".tabs__link"),
        cardsWrapper = document.querySelector(".cards"),
        cardsRows = document.querySelectorAll(".cards__row"),
        cardContainer = document.querySelector(".cards .container"),
        forms = document.getElementsByTagName("form"),
        searchMessage = document.createElement("div");

    const searchAllCards = function (form, url, $parent, $pagination) {
        searchCards(form, url).then(
            ({ data, last_page, current_page, links }) => {
                if ($parent === cardsRows[0]) {
                    $parent.classList.toggle("cards__row_active");
                    $pagination.classList.toggle("cards__pagination_active");
                }

                renderCards(data, $parent);
                new PaginationButton(
                    links,
                    form,
                    last_page,
                    current_page,
                    $parent,
                    $pagination
                );
            }
        );
    };

    const addTabListener = function (tab) {
        tab.addEventListener("shown.bs.tab", (event) => {
            searchMessage.innerHTML = ``;
            cardContainer.insertBefore(searchMessage, cardsRows[0]);

            document
                .querySelector(
                    event.target.getAttribute(`data-card-target`) + "Pagination"
                )
                .classList.toggle("cards__pagination_active");

            document
                .querySelector(
                    event.relatedTarget.getAttribute(`data-card-target`) +
                        "Pagination"
                )
                .classList.toggle("cards__pagination_active");

            document
                .querySelector(event.target.getAttribute("data-card-target"))
                .classList.toggle("cards__row_active");

            document
                .querySelector(
                    event.relatedTarget.getAttribute("data-card-target")
                )
                .classList.toggle("cards__row_active");
        });
    };

    const addFormListener = function (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();

            const url = form.getAttribute("data-url");

            searchCards(form, url).then(
                ({ data, last_page, current_page, links, total }) => {
                    const $parent = document.querySelector(
                        form.getAttribute("data-card-target")
                    );

                    const $pagination = document.querySelector(
                        form.getAttribute("data-card-target") + "Pagination"
                    );

                    clearElements($parent);
                    clearElements($pagination);

                    showSearchMessage(total);

                    renderCards(data, $parent);
                 
                    new PaginationButton(
                        links,
                        form,
                        last_page,
                        current_page,
                        $parent,
                        $pagination
                    );
                }
            );
        });
    };

    const showSearchMessage = (totalCards) => {
        if (totalCards === 0) {
            searchMessage.innerHTML = `<p class="form-label text-center mb-3">Ничего не найдено</p>`;
            cardContainer.insertBefore(searchMessage, cardsRows[0]);
        } else {
            searchMessage.innerHTML = `<p class="form-label text-center mb-3">Найдено ${totalCards}</p>`;
            cardContainer.insertBefore(searchMessage, cardsRows[0]);
        }
    };

    if (cardsWrapper) {
        try {
            for (const form of forms) {
                const url = form.getAttribute("data-url");

                const $parent = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                const $pagination = document.querySelector(
                    form.getAttribute("data-card-target") + "Pagination"
                );
                searchAllCards(form, url, $parent, $pagination);
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

export default displayCards;
