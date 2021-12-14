import "leaflet";
import { getResource } from "../services/services";

export function initMap() {
    const api_url = "http://microscope.test/map-items",
        mainMap = document.getElementById("mainMap"),
        mapWrapper = document.getElementsByClassName("map"),
        container = L.DomUtil.get("map"),
        tileLayer = L.tileLayer(
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
            {
                maxZoom: 18,
                id: "mapbox/streets-v11",
                tileSize: 512,
                zoomOffset: -1,
                accessToken:
                    "pk.eyJ1IjoidnZrNjEiLCJhIjoiY2tzNXgyMTZrMDViaTJ1cHNxbDhsbXhzcyJ9.me3r1SBREWSOPn_A3Nx5yQ",
            }
        );

    if (container != null) {
        container._leaflet_id = null;
    }

    L.map = function (id, options) {
        return new L.Map(id, options);
    };

    if (mainMap) {
        try {
            const fullMap = L.map(mainMap).setView([0, 0], 2); // показывать при первой загрузке
            tileLayer.addTo(fullMap);

            const createMarker = function (latitude, longitude, type, url) {
                let marker = L.marker([latitude, longitude]).addTo(fullMap);
                marker.bindPopup(`${type} <a href="${url}">Ссылка</a>`);
            };

            // TODO: добавить фото
            const showAllMArkers = function () {
                getResource(api_url).then((data) => {
                    data.forEach(({ type, name, url, latitude, longitude }) => {
                        createMarker(
                            Number(latitude),
                            Number(longitude),
                            type,
                            url
                        );
                    });
                });
            };

            showAllMArkers();
        } catch (error) {}
    }

    if (mapWrapper) {
        try {
            const cardMap = L.map(mapWrapper).setView([0, 0], 1); // TODO: Передавать сюда координаты камня
            tileLayer.addTo(cardMap);

            getResource(url).then((data) => {
                const latitude = data.latitude,
                    longitude = data.longitude;

                let marker = L.marker([latitude, longitude]).addTo(cardMap);
            });
        } catch (error) {}
    }

    let data = [
        {
            type: "Порода",
            name: "Poroda",
            url: "http://microscope.test/rock-info/1",
            latitude: "56.471",
            longitude: "84.957",
        },
        {
            type: "Минерал",
            name: "test",
            url: "http://microscope.test/mineral-info/12",
            latitude: "20.471",
            longitude: "30.957",
        },
        {
            type: "Окаменелость",
            name: "фул",
            url: "http://microscope.test/fossil-info/2",
            latitude: "100.471",
            longitude: "12.957",
        },
    ];

    data.forEach((el) => {
        const latitude = Number(el.latitude);
        const longitude = Number(el.longitude);
    });

    $("#accordion-button-map").on("click", function (event) {
        map();
    });
}

export default initMap;
