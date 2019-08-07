/*
	----------------------------------------------------------------------------------------
	Autenticacion de usuarios
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Location = function(options, method) {
		var defaults = {
				location: {} // latLng
			},
			settings = $.extend(true, defaults, options),
			dfd = $.Deferred(),
			that = this,
			methods = {
				geolocation: function(){
					var geoOptions = {
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
						navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions)
					}
				},
				timezone: function(){
					var location = settings.location.lat+','+settings.location.lng,
						timestamp = moment().unix();
					$.fn.request({
						url: 'https://maps.googleapis.com/maps/api/timezone/json?location='+location+'&timestamp='+timestamp+'&language='+Lang+'&key=AIzaSyC7gYBywHDf_IxnCPzbM3wHHsPDi90mwBg',
						type: 'GET'
					}).then(
						function(response){
							var r = $.parseJSON(response);
							dfd.resolve(r.status === 'OK' ? r : r.status)
						}
					)
				}
			}
		methods[method].apply(this);
		return dfd.promise();
	}
})(jQuery);


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
		navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions)
	}
	return dfd.promise();
}