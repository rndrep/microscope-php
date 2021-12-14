import "leaflet";

export function initMap() {
    const mapWrapper = document.querySelector(".map"),
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

    if (mapWrapper) {
        try {
            const adminMap = L.map("adminMap").setView([0, 0], 2), // показывать при первой загрузке
                lat = document.querySelector("#lat"),
                lng = document.querySelector("#lng"),
                initialLat = document.querySelector("#lat").value,
                initialLng = document.querySelector("#lng").value;

            let marker;

            tileLayer.addTo(adminMap);

            if (initialLat && initialLng != "") {
                console.log(initialLat && initialLng != "");
                L.marker(initialLat, initialLng).addTo(adminMap);
            }

            // TODO: поиск по карте

            adminMap.on("click", function (e) {
                console.log(e.latlng);
                lat.value = Math.round(e.latlng.lat * 1000) / 1000;
                lng.value = Math.round(e.latlng.lng * 1000) / 1000;

                if (marker != undefined) {
                    adminMap.removeLayer(marker);
                }
                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(adminMap);
            });
        } catch (error) {}
    }
}
export default initMap;
