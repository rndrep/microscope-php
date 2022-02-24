import searchCards from "./searchCards";
import renderCards from "./renderCards";
import clearElements from "./clearElements";

const pageNumbers = (total, max, current) => {
    const half = Math.floor(max / 2);
    let to = max;

    if (current + half >= total) {
        to = total;
    } else if (current > half) {
        to = current + half;
    }

    let from = Math.max(to - max, 0);

    return Array.from({ length: Math.min(total, max) }, (_, i) => i + 1 + from);
};

export function PaginationButton(
    links,
    form,
    totalPages,
    currentPage = 1,
    cardContainer,
    paginationContainer
) {
    if (totalPages <= 1) return;
    let maxPagesVisible = 5;
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
        if (disabled) buttonElement.classList.add("disabled");
     
        buttonElement.addEventListener("click", (e) => {
            handleClick(e);
            this.update();
            paginationButtonContainer.value = currentPage;
            paginationButtonContainer.dispatchEvent(
                new CustomEvent("change", { detail: { currentPageBtn } })
            );

            searchCards(form, links[currentPage].url, true).then(({ data }) => {
                clearElements(cardContainer);
                renderCards(data, cardContainer);
            });
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
            return;
        }
    };

    buttons.set(
        createAndSetupButton(
            "Начало",
            "start-page",
            disabled.start(),
            () => (currentPage = 1)
        ),
        (btn) =>
            disabled.start()
                ? btn.classList.add("disabled")
                : btn.classList.remove("disabled")
    );

    buttons.set(
        createAndSetupButton(
            "<<",
            "prev-page",
            disabled.prev(),
            () => (currentPage -= 1)
        ),
        (btn) =>
            disabled.prev()
                ? btn.classList.add("disabled")
                : btn.classList.remove("disabled")
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
        (btn) =>
            disabled.next()
                ? btn.classList.add("disabled")
                : btn.classList.remove("disabled")
    );

    buttons.set(
        createAndSetupButton(
            "Конец",
            "end-page",
            disabled.end(),
            () => (currentPage = totalPages)
        ),
        (btn) =>
            disabled.end()
                ? btn.classList.add("disabled")
                : btn.classList.remove("disabled")
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
// const paginationButtons = new PaginationButton(
//     totalPages,
//     maxPagesVisible,
//     currentPage,
//     paginationContainer
// );

export default PaginationButton;
