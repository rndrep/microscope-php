import "leaflet";
import leafletControlGeocoder from "./Control.Geocoder";

export function initMap() {
    const mapWrapper = document.querySelector(".map"),
        btnMap = document.querySelector("#btnMap"),
        tileLayer = L.tileLayer(
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
            {
                maxZoom: 18,
                minZoom: 2,
                id: "mapbox/outdoors-v11",
                tileSize: 512,
                zoomOffset: -1,
                accessToken:
                    "pk.eyJ1IjoidnZrNjEiLCJhIjoiY2tzNXgyMTZrMDViaTJ1cHNxbDhsbXhzcyJ9.me3r1SBREWSOPn_A3Nx5yQ",
            }
        ),
        createIcon = function () {
            return new L.Icon({
                iconUrl: "/img/dist/marker-icon-blue.png",
                shadowUrl: "/img/dist/marker-shadow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41],
            });
        };

    if (mapWrapper) {
        try {
            const adminMap = L.map("adminMap").setView([62, 88], 1), // показывать при первой загрузке
                lat = document.querySelector("#lat"),
                lng = document.querySelector("#lng"),
                initialLat = lat.value,
                initialLng = lng.value;

            let marker;

            const createMarker = function (lat, lng) {
                if (marker !== undefined) {
                    adminMap.removeLayer(marker);
                }

                marker = L.marker([Number(lat), Number(lng)], {
                    icon: createIcon(),
                }).addTo(adminMap);
            };

            if (initialLat && initialLng !== "") {
                createMarker(initialLat, initialLng);
            }

            tileLayer.addTo(adminMap);

            L.Control.geocoder({ defaultMarkGeocode: false })
                .on("markgeocode", function (e) {
                    let bbox = e.geocode.bbox;

                    createMarker(bbox._northEast.lat, bbox._northEast.lng);

                    lat.value = bbox._northEast.lat;
                    lng.value = bbox._northEast.lng;
                })
                .addTo(adminMap);

            adminMap.on("click", function (e) {
                lat.value = e.latlng.lat;
                lng.value = e.latlng.lng;

                createMarker(lat.value, lng.value);
            });

            btnMap.addEventListener("click", () => {
                if (lat.value && lng.value !== "") {
                    createMarker(lat.value, lng.value);
                }
            });
        } catch (error) {}
    }
}
export default initMap;
