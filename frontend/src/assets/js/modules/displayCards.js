import { param } from "jquery";
import { postData } from "../services/services.js";
import { getResource } from "../services/services.js";
import Card from "./card";

export function displayCards() {
    const tabs = document.querySelectorAll(".tabs__link"),
        cardsWrapper = document.querySelector(".cards"),
        cardsRows = document.querySelectorAll(".cards__row"),
        cardContainer = document.querySelector(".cards .container"),
        forms = document.getElementsByTagName("form"),
        searchMessage = document.createElement("div");

    const searchCards = function (form, urlResource, isPagination = false) {
        let formData = new FormData(form);

        const serializeData = (formData) => {
            let pairs = [];

            for (let [key, value] of formData.entries()) {
                pairs.push(
                    encodeURIComponent(key) + "=" + encodeURIComponent(value)
                );
            }
            return (isPagination ? "&" : "?") + pairs.join("&");
        };

        const url = urlResource + serializeData(formData);

        return getResource(url);
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

    const renderPagination = function (data, $parent, $pagination, form) {
        let currentPage = data.current_page,
            cardPerPage = data.per_page,
            namberOfCard = data.total;

        if (namberOfCard > cardPerPage) {
            for (let i = 1; i < data.last_page + 1; i++) {
                let btn = createPaginationButton(i, form);
                $pagination.append(btn);
            }
        }

        function createPaginationButton(page, form) {
            let button = document.createElement("li");
            button.classList.add("page-item");

            if (currentPage === page) button.classList.add("active");

            button.innerHTML = `<a class="page-link">${page}</a>`;

            button.addEventListener("click", function (event) {
                currentPage = page;

                if (this.classList.contains("active")) {
                    return;
                }

                searchCards(form, data.links[currentPage].url, true).then(
                    (dataCurrentPage) => {
                        clearElements($parent);
                        renderCards(dataCurrentPage, $parent);
                    }
                );

                for (let i = 0; i < $pagination.children.length; i++) {
                    if ($pagination.children[i].classList.contains("active")) {
                        $pagination.children[i].classList.remove("active");
                    }
                }

                this.classList.add("active");
            });

            return button;
        }
    };

    const clearElements = function (selector) {
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

            searchCards(form, url).then((data) => {
                const $parent = document.querySelector(
                    form.getAttribute("data-card-target")
                );

                const $pagination = document.querySelector(
                    form.getAttribute("data-card-target") + "Pagination"
                );

                clearElements($parent);
                clearElements($pagination);

                showSearchMessage(data);

                renderCards(data, $parent);
                renderPagination(data, $parent, $pagination, form);
            });
        });
    };

    const showSearchMessage = (data) => {
        if (data.total === 0) {
            searchMessage.innerHTML = `<p class="form-label text-center mb-3">Ничего не найдено</p>`;
            cardContainer.insertBefore(searchMessage, cardsRows[0]);
        } else {
            searchMessage.innerHTML = `<p class="form-label text-center mb-3">Найдено ${data.total}</p>`;
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
