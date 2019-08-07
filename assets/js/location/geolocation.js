/*
	----------------------------------------------------------------------------------------
	Servicio de geolocalicacion
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
'use strict';
function geolocation(){
	var dfd = $.Deferred(),
		geoOptions = {
			//timeout: 5000,
			maximumAge: 0,
			enableHighAccuracy: true
		},
		geoSuccess = function(position){
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			}
			dfd.resolve(pos)
		},
		geoError = function(error){
			var modal = DomRootEl.find('#modal-geolocation-error')
			dfd.resolve({});
			modal.modal({
				centered: false,
				inverted: true
			})
			.modal('setting', 'transition', 'horizontal flip')
			.modal('show')
			.find('h4').text('Error occurred. Error code '+error.code+'  '+error.message)
		};
	if (navigator.geolocation) {
		navigator.geolocation.watchPosition(geoSuccess, geoError, geoOptions)
	}
	return dfd.promise();
}