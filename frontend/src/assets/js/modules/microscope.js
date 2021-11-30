export default class Microscope {
    STEP5 = 5;
    STEP10 = 10;
    microscopeDegree = document.querySelector(".microscope__degree");
    isShowDegree = false;
    numberOfImg;

    constructor(
        microscopeElement,
        imgSources = [],
        parentSelector,
        step,
        smooth = true,
        rotation = 0
    ) {
        this.microscopeElement = microscopeElement;
        this.imgSources = imgSources.reverse(); //TODO: убрать после переворачивания картинок
        this.parent = document.querySelector(parentSelector);
        this.step = step;
        this.smooth = smooth;
        this.rotation = rotation;
        this.initRotation();
        this.createImg(this.step);
    }

    toggleShowDegree() {
        this.isShowDegree = !this.isShowDegree;
        return this;
    }

    initRotation() {
        if (this.step == this.STEP5) {
            this.numberOfImg = 72;
        } else if (this.step == this.STEP10) {
            this.numberOfImg = 36;
        } else console.log("Задан неверный шаг");

        this.sectionDeg = 360 / this.numberOfImg;
        this.sectionPercent = (this.rotation / this.sectionDeg) % 1;
        this.index = Math.floor(this.rotation / this.sectionDeg);
        this.prev = 0 === this.index ? this.numberOfImg - 1 : this.index - 1;
        this.next = this.numberOfImg - 1 === this.index ? 0 : this.index + 1;
        this.curRot = this.getRotationStyle(this.getDegree());
        this.nextRot = this.getRotationStyle(this.getDegree(-1));
        this.prevRot = this.getRotationStyle(this.getDegree(1));
    }

    update(step, smooth, rotation) {
        rotation = rotation - 360 * Math.floor(rotation / 360);
        if (smooth == false && step == this.STEP10) {
            rotation = Math.floor(rotation / 10) * 10;
        } else if (smooth == false && step == this.STEP5) {
            rotation = Math.floor(rotation / 5) * 5;
        }

        this.sectionPercent = (rotation / this.sectionDeg) % 1;
        this.index = Math.floor(rotation / this.sectionDeg);
        this.prev = 0 === this.index ? this.numberOfImg - 1 : this.index - 1;
        this.next = this.numberOfImg - 1 === this.index ? 0 : this.index + 1;
        this.curRot = this.getRotationStyle(this.getDegree());
        this.nextRot = this.getRotationStyle(this.getDegree(-1));
        this.prevRot = this.getRotationStyle(this.getDegree(1));
        this.render(step, smooth, rotation);
    }

    createImg() {
        this.imgElements = this.imgSources.map((image, i, all) => {
            let imgElement = document.createElement("img");
            imgElement.src = image;

            return imgElement;
        });
        console.log(this.imgElements);
        if (this.step == this.STEP5) {
            let imgElementsClone = [];
            this.imgElements.forEach((item) => {
                imgElementsClone.push(item.cloneNode());
            });
            this.imgElements.push(...imgElementsClone);
        }

        this.imgElements.forEach((item) => {
            if (this.microscopeElement) {
                try {
                    this.microscopeElement.append(item);
                } catch (error) {}
            }
        });

        if (this.parent) {
            try {
                this.parent.append(this.microscopeElement);
            } catch (error) {}
        }
    }

    setRotation(value) {
        this.rotation = value;
    }

    getRotationStyle(rotationValue) {
        return this.sectionDeg ? `rotate(${rotationValue}deg)` : "";
    }

    getDegree(delta = 0) {
        let offset = 0;
        if (delta > 0) {
            offset = this.sectionDeg;
        } else if (delta < 0) {
            offset = this.sectionDeg * -1;
        }
        return this.sectionPercent * this.sectionDeg + offset;
    }

    render(step, smooth, rotation) {
        if (this.isShowDegree) {
            this.microscopeDegree.innerHTML = `${Math.round(rotation)}°`;
        }

        this.imgElements.forEach((item, i, arr) => {
            const isCurr = i === this.index;
            const isPrev = i === this.prev;
            const isNext = i === this.next;

            const getVisibility = () => {
                return isCurr || isNext ? "visible" : "hidden";
            };

            const getOpacity = (smooth) => {
                if (isCurr) {
                    return 1;
                }
                if (this.sectionPercent === 0) {
                    if (!isCurr) {
                        return 0;
                    }
                } else {
                    if (isNext) {
                        return this.sectionPercent;
                    }
                }
            };

            const getTransform = (step, smooth) => {
                let reflection =
                    i < arr.length / 2 ? "rotateZ(0deg)" : "rotateZ(180deg)";
                let smoothness = () => {
                    let rotate = "";
                    if (isCurr) {
                        rotate = this.curRot;
                    }
                    if (isPrev) {
                        rotate = this.prevRot;
                    }
                    if (isNext) {
                        rotate = this.nextRot;
                    }
                    return rotate;
                };
                if (step == this.STEP5 && smooth == false) {
                    return reflection;
                } else if (step == this.STEP10 && smooth == true) {
                    return smoothness();
                } else if (step == this.STEP5 && smooth == true) {
                    let scale = reflection;
                    let rotate = smoothness();
                    return rotate + " " + scale;
                }
            };

            const style = {
                zIndex: 10 + i,
                visibility: getVisibility(),
                transform: getTransform(step, smooth),
                opacity: getOpacity(smooth),
            };

            item.setAttribute(
                "class",
                `microscope__img ${isCurr ? "yes" : ""}`
            );

            item.style.visibility = style.visibility;
            item.style.zIndex = style.zIndex;
            item.style.transform = style.transform;
            item.style.opacity = style.opacity;
        });
    }
}
