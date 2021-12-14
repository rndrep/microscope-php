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
            const adminMap = L.map("adminMap").setView([0, 0], 2); // показывать при первой загрузке
            tileLayer.addTo(adminMap);

            // TODO: поиск по карте
            adminMap.on("click", function (e) {
                console.log(e.latlng);
            });
        } catch (error) {}
    }
}
export default initMap;
