import { getResource } from "../services/services";

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

export default searchCards;
