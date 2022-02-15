import Card from "./card";

const renderCards = function (data, $parent) {
    const cards = data;

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

export default renderCards;
