/*
	----------------------------------------------------------------------------------------
	Autenticacion de usuarios
	Location: assets/js
	----------------------------------------------------------------------------------------
*/
(function($) {
	'use strict';
	$.fn.Address = function(options, method) {
		var defaults = {
				location: {}, // latLng
				placeId: null, // string
				address: null // string
			},
			settings = $.extend(true, defaults, options),
			dfd = $.Deferred(),
			that = this,
			geocoder,
			address,
			methods = {
				construct: function(){
					geocoder = new google.maps.Geocoder();
				},
				// Devuelve una direccion dada su latitud y longitud
				get: function(){
					geocoder.geocode( { 'location': settings.location }, function(results, status) {
						if (status == 'OK') {
							dfd.resolve(addressComponents(results[0]))
						} else {
							dfd.resolve({status})
						}
					});

				},
				fill: function(){

				}
			}
		methods.construct();
		methods[method].apply(this);
		return dfd.promise();
	}

	function addressComponents(data){
		var components = [];
		for(var i = 0; i < data.address_components.length; i++){
			components[data.address_components[i].types[0]] = {
				short_name: data.address_components[i].short_name,
				long_name: data.address_components[i].long_name
			}
		}
		components['formatted_address'] = data['formatted_address'];
		components['geometry'] = data['geometry'];
		components['place_id'] = data['place_id'];

		return components;
	}

})(jQuery);

/*
	{
  "address_components": [
    {
      "long_name": "3838",
      "short_name": "3838",
      "types": [
        "street_number"
      ]
    },
    {
      "long_name": "Norberto Ortiz",
      "short_name": "Norberto Ortiz",
      "types": [
        "route"
      ]
    },
    {
      "long_name": "Montevideo",
      "short_name": "Montevideo",
      "types": [
        "locality",
        "political"
      ]
    },
    {
      "long_name": "Departamento de Montevideo",
      "short_name": "Departamento de Montevideo",
      "types": [
        "administrative_area_level_1",
        "political"
      ]
    },
    {
      "long_name": "Uruguay",
      "short_name": "UY",
      "types": [
        "country",
        "political"
      ]
    },
    {
      "long_name": "12300",
      "short_name": "12300",
      "types": [
        "postal_code"
      ]
    }
  ],
  "formatted_address": "Norberto Ortiz 3838, 12300 Montevideo, Departamento de Montevideo, Uruguay",
  "geometry": {
    "location": {},
    "location_type": "ROOFTOP",
    "viewport": {
      "na": {
        "j": -34.8589362802915,
        "l": -34.8562383197085
      },
      "ia": {
        "j": -56.172055680291464,
        "l": -56.1693577197085
      }
    }
  },
  "place_id": "ChIJyxKE15wqoJURJYi5yZbxGJE",
  "plus_code": {
    "compound_code": "4RRH+XP Montevideo, Departamento de Montevideo, Uruguay",
    "global_code": "48Q54RRH+XP"
  },
  "types": [
    "street_address"
  ]
}
*/