import "leaflet";
import { getResource } from "../services/services";

export function initMap() {
    const api_url = "http://microscope.test/map-items",
        mainMap = document.getElementById("mainMap"),
        cardMap = document.getElementById("cardMap"),
        container = L.DomUtil.get("map"),
        initLayer = function (id) {
            return L.tileLayer(
                "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
                {
                    maxZoom: 18,
                    minZoom: 2,
                    id: id,
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken:
                        "pk.eyJ1IjoidnZrNjEiLCJhIjoiY2tzNXgyMTZrMDViaTJ1cHNxbDhsbXhzcyJ9.me3r1SBREWSOPn_A3Nx5yQ",
                }
            );
        },
        baseMaps = {
            Спутник: initLayer("mapbox/satellite-v9"),
            Улицы: initLayer("mapbox/streets-v11"),
        },
        createIcon = function (iconColor = "blue") {
            let customIcon;
            if (iconColor === "orange") {
                customIcon = "/img/dist/marker-icon-orange.png";
            } else if (iconColor === "blue") {
                customIcon = "/img/dist/marker-icon-blue.png";
            } else if (iconColor === "green") {
                customIcon = "/img/dist/marker-icon-green.png";
            }

            return new L.Icon({
                iconUrl: customIcon,
                shadowUrl: "/img/dist/marker-shadow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41],
            });
        },
        createMarker = function (
            type,
            longitude,
            latitude,
            name,
            url,
            popup = true
        ) {
            let customIcon;

            if (type === "Порода") {
                customIcon = createIcon("orange");
            } else if (type === "Минерал") {
                customIcon = createIcon("blue");
            } else if (type === "Окаменелость") {
                customIcon = createIcon("green");
            }

            const marker = L.marker([longitude, latitude], {
                icon: customIcon,
                riseOnHover: true,
            });

            popup === true
                ? marker.bindPopup(`<a href="${url}">${name}</a>`)
                : marker.bindPopup(`${name}`);

            return marker;
        };

    if (mainMap) {
        try {
            const fullMap = L.map(mainMap).setView([40, 5], 1); // показывать при первой загрузке
            initLayer("mapbox/streets-v11").addTo(fullMap);

            // TODO: добавить фото
            const showAllMArkers = function () {
                getResource(api_url).then((data) => {
                    let rocksGroup = [],
                        mineralsGroup = [],
                        fossilsGroup = [];

                    data.forEach(({ type, name, url, lng, lat }) => {
                        if (lat && lng != "") {
                            const marker = createMarker(
                                type,
                                Number(lng),
                                Number(lat),
                                name,
                                url
                            );

                            if (type === "Порода") {
                                rocksGroup.push(marker);
                            } else if (type === "Минерал") {
                                mineralsGroup.push(marker);
                            } else if (type === "Окаменелость") {
                                fossilsGroup.push(marker);
                            }
                        }
                    });

                    const overlayMaps = {
                        Породы: L.layerGroup(rocksGroup),
                        Минералы: L.layerGroup(mineralsGroup),
                        Окаменелости: L.layerGroup(fossilsGroup),
                    };

                    L.control
                        .layers(baseMaps, overlayMaps, {
                            collapsed: false,
                            hideSingleBase: true,
                        })
                        .addTo(fullMap);

                    L.layerGroup([
                        overlayMaps.Породы,
                        overlayMaps.Минералы,
                        overlayMaps.Окаменелости,
                    ]).addTo(fullMap);
                });
            };

            showAllMArkers();
        } catch (error) {}
    }

    if (cardMap) {
        try {
            const specificMap = L.map(cardMap);

            getResource(api_url).then((data) => {
                data.forEach(({ type, name, url, lng, lat }) => {
                    if (name === cardMap.getAttribute("data-name")) {
                        if (lat && lng != "") {
                            specificMap.setView([lng, lat], 2);

                            initLayer("mapbox/streets-v11").addTo(specificMap);

                            createMarker(
                                type,
                                Number(lng),
                                Number(lat),
                                name,
                                url,
                                false
                            ).addTo(specificMap);

                            L.control
                                .layers(baseMaps, null, {
                                    collapsed: false,
                                    hideSingleBase: true,
                                })
                                .addTo(specificMap);
                        }
                    }
                });
            });
        } catch (error) {}
    }
}

export default initMap;
