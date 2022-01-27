import { param } from "jquery";
import { postData } from "../services/services.js";
import { getResource } from "../services/services.js";
import Card from "./card";

export function renderCards(urlResource) {
    const tabs = document.querySelectorAll(".tabs__link"),
        cardsWrapper = document.querySelector(".cards"),
        cardsRows = document.querySelectorAll(".cards__row"),
        cardContainer = document.querySelector(".cards .container"),
        forms = document.getElementsByTagName("form"),
        messageFail = document.createElement("div"),
        searchMessage = document.createElement("div"),
        $pagination = document.getElementById("pagination");

    const searchCards = function (form, urlResource) {
        let formData = new FormData(form);

        const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));

        return postData(urlResource, jsonData);
    };

    const renderCards = function (data, $parent) {
        const cards = data.data;

        cards.forEach(({ photo, name, info_url, microscope_url, model_3d }) => {
            new Card(
                photo,
                name,
                info_url,
                microscope_url,
                model_3d,
                $parent
            ).render();
        });
    };

    const renderPagination = function (data, $parent, $pagination) {
        let currentPage = data.current_page,
            cardPerPage = data.per_page,
            pageCount = data.last_page;

        for (let i = 1; i < data.last_page + 1; i++) {
            let btn = createPaginationButton(i);
            $pagination.append(btn);
        }

        function createPaginationButton(page) {
            let button = document.createElement("li");
            button.classList.add("page-item");

            if (currentPage === page) button.classList.add("active");

            button.innerHTML = `<a class="page-link">${page}</a>`;

            button.addEventListener("click", function () {
                currentPage = page;

                getResource(data.links[currentPage].url).then((data) => {
                    clearCards($parent);

                    renderCards(data, $parent);
                });

                let currentButton = document.querySelector(".page-item.active");
                currentButton.classList.remove("active");

                this.classList.add("active");
            });

            return button;
        }
    };

    const clearCards = function (selector) {
        while (selector.firstChild) {
            selector.removeChild(selector.firstChild);
        }
    };

    const searchAllCards = function (form, url, $parent, $pagination) {
        searchCards(form, url).then((data) => {
            if ($parent === cardsRows[0]) {
                $parent.classList.toggle("cards__row_active");
                $pagination.classList.toggle("cards__pagination_active");
            }

            renderCards(data, $parent);
            renderPagination(data, $parent, $pagination);
        });
    };

    const addTabListener = function (tab) {
        tab.addEventListener("shown.bs.tab", (event) => {
            messageFail.innerHTML = ``;
            cardContainer.insertBefore(messageFail, cardsRows[0]);

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

            searchCards(form, url).then((data) => {
                const $parent = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                clearCards($parent);

                if (data.data.length === 0) {
                    messageFail.innerHTML = `<p class="form-label text-center mb-3">Ничего не найдено</p>`;
                    cardContainer.insertBefore(messageFail, cardsRows[0]);
                } else {
                    messageFail.innerHTML = `<p class="form-label text-center mb-3">Найдено ${data.data.length}</p>`;
                    cardContainer.insertBefore(messageFail, cardsRows[0]);
                }

                renderCards(data, $parent);
            });
        });
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

export default renderCards;
