import "gsap";
import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";
import { getResource } from "../services/services.js";
gsap.registerPlugin(Draggable);

export function microscope(urlResource) {
	const url = urlResource;
	const microscopePpl = document.createElement("div");
	const microscopeXpl = document.createElement("div");
	const ppl = document.getElementsByClassName("ppl");
	const xpl = document.getElementsByClassName("xpl");
	microscopePpl.className = "microscope__circle";
	microscopeXpl.className = "microscope__circle";

	ppl[0].append(microscopePpl);
	xpl[0].append(microscopeXpl);

	getResource(url).then((data) => {
		const step = data.shift;
		const isSmooth = data.smooth;
		const initRotation = 0;

		const pplMicroscope = new Microscope(
			microscopePpl,
			data.ppl,
			".ppl",
			step,
			isSmooth,
			initRotation
		).toggleShowDegree();

		pplMicroscope.render(step, isSmooth, initRotation);

		const xplMicroscope = new Microscope(
			microscopeXpl,
			data.xpl,
			".xpl",
			step,
			isSmooth,
			initRotation
		);
		xplMicroscope.render(step, isSmooth, initRotation);

		Draggable.create(".wheel", {
			type: "rotation",
			minimumMovement: 1,

			onDrag(e) {
				pplMicroscope.update(step, isSmooth, this.rotation);
				xplMicroscope.update(step, isSmooth, this.rotation);
			},
		});
	});

	class Microscope {
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
			this.rotation = rotation;
			this.smooth = smooth;
			this.step = step;
			this.parent = document.querySelector(parentSelector);
			this.initRotation();
			this.microscopeDegree = document.querySelector(".microscope__degree");
			this.createImg(this.step);
			this.isShowDegree = false;
		}

		toggleShowDegree() {
			this.isShowDegree = !this.isShowDegree;
			return this;
		}

		initRotation() {
			this.sectionDeg = 360 / this.imgSources.length;
			this.sectionDeg = 5; //TODO: fix
			this.sectionPercent = (this.rotation / this.sectionDeg) % 1;
			this.index = Math.floor(this.rotation / this.sectionDeg);
			this.prev = 0 === this.index ? this.imgSources.length - 1 : this.index - 1;
			this.next = this.imgSources.length - 1 === this.index ? 0 : this.index + 1;
			this.curRot = this.getRotationStyle(this.getDegree());
			this.nextRot = this.getRotationStyle(this.getDegree(-1));
			this.prevRot = this.getRotationStyle(this.getDegree(1));
		}

		update(step, smooth, rotation) {
			rotation = rotation - 360 * Math.floor(rotation / 360);
			if (smooth == false && step == 10) {
				rotation = Math.floor(rotation / 10) * 10;
			} else if (smooth == false && step == 5) {
				rotation = Math.floor(rotation / 5) * 5;
			}

			this.sectionPercent = (rotation / this.sectionDeg) % 1;
			this.index = Math.floor(rotation / this.sectionDeg);
			this.prev = 0 === this.index ? this.imgSources.length - 1 : this.index - 1;
			this.next = this.imgSources.length - 1 === this.index ? 0 : this.index + 1;
			this.curRot = this.getRotationStyle(this.getDegree());
			this.nextRot = this.getRotationStyle(this.getDegree(-1));
			this.prevRot = this.getRotationStyle(this.getDegree(1));
			this.render(step, smooth, rotation);
		}

		createImg(step) {
			// TODO:скопировать картинки здесь
			this.imgElements = this.imgSources.map((image, i, all) => {
				let imgElement = document.createElement("img");
				imgElement.src = image;

				return imgElement;
			});

			if (step == 5) {
				let imgElementsClone = [];
				this.imgElements.forEach((item) => {
					imgElementsClone.push(item.cloneNode());
				});
				// imgElementsClone.reverse();
				this.imgElements.push(...imgElementsClone);
			}

			this.imgElements.forEach((item) => {
				this.microscopeElement.append(item);
			});

			this.parent.append(this.microscopeElement);
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

				// const getTransform = () => {
				// 	let rotate = "";
				// 	if (isCurr) {
				// 		rotate = this.curRot;
				// 	}
				// 	if (isPrev) {
				// 		rotate = this.prevRot;
				// 	}
				// 	if (isNext) {
				// 		rotate = this.nextRot;
				// 	}
				// 	// return rot + " " + scale;
				// 	return rotate;
				// };

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
					if (step == 5 && smooth == false) {
						return reflection;
					} else if (step == 10 && smooth == true) {
						return smoothness();
					} else if (step == 5 && smooth == true) {
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

				item.className = `microscope__img ${isCurr ? "yes" : ""}`;
				item.style.visibility = style.visibility;
				item.style.zIndex = style.zIndex;
				item.style.transform = style.transform;
				item.style.opacity = style.opacity;
			});
		}
	}
}

export default microscope;
