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
                id: "mapbox/streets-v11",
                tileSize: 512,
                zoomOffset: -1,
                accessToken:
                    "pk.eyJ1IjoidnZrNjEiLCJhIjoiY2tzNXgyMTZrMDViaTJ1cHNxbDhsbXhzcyJ9.me3r1SBREWSOPn_A3Nx5yQ",
            }
        );

    if (mapWrapper) {
        try {
            const adminMap = L.map("adminMap").setView([62, 88], 1), // показывать при первой загрузке
                lat = document.querySelector("#lat"),
                lng = document.querySelector("#lng"),
                initialLat = lat.value,
                initialLng = lng.value;

            let marker;

            tileLayer.addTo(adminMap);
            L.Control.geocoder().addTo(adminMap);

            if (initialLat && initialLng != "") {
                marker = L.marker([
                    Number(initialLat),
                    Number(initialLng),
                ]).addTo(adminMap);
            }

            adminMap.on("click", function (e) {
                lat.value = e.latlng.lat;
                lng.value = e.latlng.lng;

                if (marker != undefined) {
                    adminMap.removeLayer(marker);
                }

                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(adminMap);
            });

            btnMap.addEventListener("click", () => {
                if (lat.value && lng.value != "") {
                    if (marker != undefined) {
                        adminMap.removeLayer(marker);
                    }
                    marker = L.marker([
                        Number(lat.value),
                        Number(lng.value),
                    ]).addTo(adminMap);
                }
            });
        } catch (error) {}
    }
}
export default initMap;
