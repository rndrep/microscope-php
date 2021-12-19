import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";
gsap.registerPlugin(Draggable);
import Microscope from "./microscope";
import { getResource } from "../services/services.js";

export function createMicroscope(urlResource) {
    const url = urlResource;

    const ppl = document.getElementById("ppl");
    const xpl = document.getElementById("xpl");

    const microscopePpl = document.createElement("div");
    const microscopeXpl = document.createElement("div");
    microscopePpl.className = "microscope__circle";
    microscopeXpl.className = "microscope__circle";

    getResource(url).then((data) => {
        const step = data.shift;
        const isSmooth = data.smooth;
        const initRotation = 0;

        const pplMicroscope = new Microscope(
            microscopePpl,
            data.ppl,
            "#ppl",
            step,
            isSmooth,
            initRotation
        ).toggleShowDegree();

        pplMicroscope.render(step, isSmooth, initRotation);

        const xplMicroscope = new Microscope(
            microscopeXpl,
            data.xpl,
            "#xpl",
            step,
            isSmooth,
            initRotation
        );
        xplMicroscope.render(step, isSmooth, initRotation);

        Draggable.create(".microscope__wheel", {
            type: "rotation",
            minimumMovement: 1,

            onDrag(e) {
                pplMicroscope.update(step, isSmooth, this.rotation);
                xplMicroscope.update(step, isSmooth, this.rotation);
            },
        });
    });
}

export default createMicroscope;
