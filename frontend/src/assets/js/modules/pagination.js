import searchCards from "./searchCards";
import renderCards from "./renderCards";
import clearElements from "./clearElements";

export function pagination(
    links,
    form,
    totalPages,
    maxPagesVisible,
    currentPage,
    paginationContainer,
    cardContainer
) {
    const pageNumbers = (total, max, current) => {
        const half = Math.floor(max / 2);
        let to = max;

        if (current + half >= total) {
            to = total;
        } else if (current > half) {
            to = current + half;
        }

        let from = Math.max(to - max, 0);

        return Array.from(
            { length: Math.min(total, max) },
            (_, i) => i + 1 + from
        );
    };

    function PaginationButton(
        totalPages,
        maxPagesVisible = 10,
        currentPage = 1,
        paginationContainer
    ) {
        let pages = pageNumbers(totalPages, maxPagesVisible, currentPage);
        let currentPageBtn = null;
        const buttons = new Map();
        const disabled = {
            start: () => pages[0] === 1,
            prev: () => currentPage === 1 || currentPage > totalPages,
            end: () => pages.slice(-1)[0] === totalPages,
            next: () => currentPage >= totalPages,
        };
        const frag = document.createDocumentFragment();
        const paginationButtonContainer = paginationContainer;

        const createAndSetupButton = (
            label = "",
            cls = "",
            disabled = false,
            handleClick
        ) => {
            const buttonElement = document.createElement("li");
            buttonElement.className = `page-item`;

            const linkElement = document.createElement("a");
            linkElement.className = "page-link";
            linkElement.textContent = label;
            buttonElement.appendChild(linkElement);

            buttonElement.className = `page-item ${cls}`;
            buttonElement.disabled = disabled;
            buttonElement.addEventListener("click", (e) => {
                handleClick(e);
                this.update();
                paginationButtonContainer.value = currentPage;
                paginationButtonContainer.dispatchEvent(
                    new CustomEvent("change", { detail: { currentPageBtn } })
                );
            });

            return buttonElement;
        };

        const onPageButtonClick = (e) =>
            (currentPage = Number(e.currentTarget.textContent));

        const onPageButtonUpdate = (index) => (btn) => {
            btn.firstElementChild.textContent = pages[index];

            if (pages[index] === currentPage) {
                currentPageBtn.classList.remove("active");
                btn.classList.add("active");
                currentPageBtn = btn;
                currentPageBtn.focus();
            }

            if (
                btn.classList.contains("active") ||
                currentPage > totalPages ||
                currentPage <= 0
            ) {
                // debugger;
                return;
            }

            searchCards(form, links[currentPage].url, true).then(({ data }) => {
                clearElements(cardContainer);
                renderCards(data, cardContainer);
            });
        };

        buttons.set(
            createAndSetupButton(
                "Начало",
                "start-page",
                disabled.start(),
                () => (currentPage = 1)
            ),
            (btn) => (btn.disabled = disabled.start())
        );

        buttons.set(
            createAndSetupButton(
                "<<",
                "prev-page",
                disabled.prev(),
                () => (currentPage -= 1)
            ),
            (btn) => (btn.disabled = disabled.prev())
        );

        pages.map((pageNumber, index) => {
            const isCurrentPage = currentPage === pageNumber;
            const button = createAndSetupButton(
                pageNumber,
                isCurrentPage ? "active" : "",
                false,
                onPageButtonClick
            );

            if (isCurrentPage) {
                currentPageBtn = button;
            }

            buttons.set(button, onPageButtonUpdate(index));
        });

        buttons.set(
            createAndSetupButton(
                ">>",
                "next-page",
                disabled.next(),
                () => (currentPage += 1)
            ),
            (btn) => (btn.disabled = disabled.next())
        );

        buttons.set(
            createAndSetupButton(
                "Конец",
                "end-page",
                disabled.end(),
                () => (currentPage = totalPages)
            ),
            (btn) => (btn.disabled = disabled.end())
        );

        buttons.forEach((_, btn) => frag.appendChild(btn));
        paginationButtonContainer.appendChild(frag);

        this.render = (container = document.body) => {
            container.appendChild(paginationButtonContainer);
        };

        this.update = (newPageNumber = currentPage) => {
            currentPage = newPageNumber;
            pages = pageNumbers(totalPages, maxPagesVisible, currentPage);
            buttons.forEach((updateButton, btn) => updateButton(btn));
        };

        this.onChange = (handler) => {
            paginationButtonContainer.addEventListener("change", handler);
        };
    }

    const paginationButtons = new PaginationButton(
        totalPages,
        maxPagesVisible,
        currentPage,
        paginationContainer
    );
}

export default pagination;
