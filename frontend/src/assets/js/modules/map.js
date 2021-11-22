import "leaflet";

export function map() {
	var container = L.DomUtil.get("map");
	if (container != null) {
		container._leaflet_id = null;
	}

	var mymap = L.map("map").setView([56.471, 84.957], 13);

	L.tileLayer(
		"https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
		{
			attribution:
				'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			maxZoom: 18,
			id: "mapbox/streets-v11",
			tileSize: 512,
			zoomOffset: -1,
			accessToken:
				"pk.eyJ1IjoidnZrNjEiLCJhIjoiY2tzNXgyMTZrMDViaTJ1cHNxbDhsbXhzcyJ9.me3r1SBREWSOPn_A3Nx5yQ",
		}
	).addTo(mymap);

	// mymap.invalidateSize();

	// $("#map").on("hidden.bs.collapse", function () {
	//     initialize_map();
	// });

	// $("#map").on("shown.bs.collapse", function () {
	//     initialize_map();
	// });
}

export default map;
