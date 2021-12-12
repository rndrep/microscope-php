const getResource = async (urlResource) => {
    // GET запрос возвращает промис http://vmicro.tpu.ru/microscope/rock/test
    const res = await fetch(urlResource);

    if (!res.ok) {
        throw new Error(`Could not fetch ${url}, status: ${res.status}`);
    }

    return await res.json();
};

// const postData = async (data, urlResource) => {
//     return new Promise(function (resolve, reject) {
//         let request = new XMLHttpRequest();
//         // указываем зачем и куда идет запрос
//         request.open("POST", urlResource);

//         // отправка в JSON формате
//         request.setRequestHeader(
//             "Content-type",
//             "application/json; charset=utf-8"
//         );

//         // после получения состояния запроса можем что-то сделать и вывести сообщение
//         request.onreadystatechange = function () {
//             if (request.readyState < 4) {
//                 resolve();
//             } else if (request.readyState === 4) {
//                 if (request.readyState === 200 && request.readyState < 3) {
//                     resolve();
//                 } else {
//                     reject();
//                 }
//             }
//         };

//         request.send(data);
//     });
// };

const postData = async (urlResource, data, headers = {}) => {
    const res = await fetch(urlResource, {
        method: "POST",
        body: data,
        headers: {
            "Content-type": "application/json",
            Accept: "application/json",
            ...headers
        },
    });

    if (!res.ok) {
        throw new Error(`Could not fetch ${url}, status: ${res.status}`);
    }

    return await res.json();
};

const deleteData = async (urlResource, data, headers = {}) => {
    const res = await fetch(urlResource, {
        method: "POST",
        body: data,
        headers: {
            ...headers
        },
    });

    if (!res.ok) {
        throw new Error(`Could not fetch ${url}, status: ${res.status}`);
    }

    return await res.json();
};

export { getResource };
export { postData };
export { deleteData };
