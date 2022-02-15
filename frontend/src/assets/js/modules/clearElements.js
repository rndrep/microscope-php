const clearElements = function (selector) {
    while (selector.firstChild) {
        selector.removeChild(selector.firstChild);
    }
};

export default clearElements;
