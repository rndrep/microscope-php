export default class Card {
    constructor(
        imgSrc,
        title,
        infoUrl = "",
        microUrl = "",
        turnUrl = "",
        parentSelector
    ) {
        this.imgSrc = imgSrc;
        this.title = title;
        this.infoUrl = infoUrl;
        this.microUrl = microUrl;
        this.turnUrl = turnUrl;
        this.parent = parentSelector;
        //ссылки на инфо/микро/3д для карточки
    }

    render() {
        const cardCol = document.createElement("div");
        cardCol.classList.add("col");
        let microBtn, turnBtn;
        if (this.microUrl === "") {
            microBtn = "";
        } else {
            microBtn = `
            <a class="btn btn_group" href="${this.microUrl}" aria-label="Микроскоп">
            <svg class="icon" >
                <use href="/svg/sprite.svg#biotech"></use>
            </svg>
            </a>
        `;
        }

        console.log(microBtn);

        if (this.turnUrl === "") {
            turnBtn = "";
        } else {
            turnBtn = `
            <a class="btn btn_group" href="${this.turnUrl}" aria-label="Микроскоп">
            <svg class="icon" >
                <use href="/svg/sprite.svg#biotech"></use>
            </svg>
            </a>
        `;
        }

        cardCol.innerHTML = `
                <div class="card">
                    <!-- card__thumb -->
                    <a class="card__thumb" href="${this.infoUrl}">
                        <img class="card__img" src="${this.imgSrc}"/>
                        <h3 class="card__title" aria-label="Фото">${this.title}</h3>
                    </a>
                    <!-- ./ card__thumb -->
                    <!-- card__body -->
                    <div class="card__body">
                        <div class="btn-group card__btn-group" role="group">
                            <a class="btn btn_group" href="${this.infoUrl}" aria-label="Информация"><svg class="icon" >
                                <use href="/svg/sprite.svg#feed"></use>
                            </svg></a>
                           ${microBtn}
                           ${turnBtn}
                        </div>
                    </div>
                    <!-- ./ card__body -->
                </div>
            `;

        this.parent.append(cardCol);
    }
}
