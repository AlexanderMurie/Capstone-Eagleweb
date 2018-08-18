//Import Open Terrain Layer Tile Map
	var mymap = L.map('mapid').setView([-28.378272, 23.913711], 5);
	var Stamen_Terrain = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.{ext}', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 18,
		ext: 'png'
		});
	mymap.addLayer(Stamen_Terrain);
	//Simple Scale Bar, must have on map following basic cartographic principles.
	L.control.scale().addTo(mymap);

/*
mymap.on('click', function(e) {
});
*/