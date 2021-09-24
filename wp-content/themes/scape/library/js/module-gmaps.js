
(function() {
	"use strict";
	window.SCAPE = window.SCAPE || {};
	var $ = jQuery.noConflict();

	SCAPE.googleMaps = {

		bounds: {},

		locations: [],

		init: function(options) {

			if ( 'undefined' !== typeof google ) {
				var styles = options.styles !== 'default' ? options.styles : null;

				var map = new google.maps.Map(document.getElementById(options.map), {
					mapTypeId		: 'roadmap',
					styles			: options.styles,
					scrollwheel		: options.scrollwheel,
					mapTypeControl	: options.mapTypeControl,
					zoomControl		: options.zoomControl,
					streetViewControl: options.streetViewControl,
					draggable		: options.draggable,
					controlSize		: 30
				});

				var geocoder = new google.maps.Geocoder();

				SCAPE.googleMaps.bounds = new google.maps.LatLngBounds();

				if ( options.center === 'manual' ) {
					var center = new google.maps.LatLng(options.lat, options.lng);
					map.panTo(center);
					map.setZoom(options.zoom);
				}

				var infowindow = new google.maps.InfoWindow({
					content: '',
					disableAutoPan: true
				});

				if ( options.locations ) {
					var i = 0;
					var interval = options.locations.length * 30;

					var geoInterval = setInterval(function() {
						var image = (options.locations[i].image === '') ? '' : '<div class="wtbx_iw_image"><img src="' + options.locations[i].image + '"></div>';
						var title = (options.locations[i].title === '') ? '' : '<h6 class="wtbx_iw_title">' + options.locations[i].title + '</h6>';
						var description = (options.locations[i].description === '') ? '' : '<div class="wtbx_iw_descr">' + options.locations[i].description + '</div>';
						var address = (options.locations[i].address === '') ? '' : '<div class="wtbx_iw_address">' + options.locations[i].address + '</div>';
						var content;

						if ( options.locations[i].style === 'default' ) {
							content =
								'<div class="wtbx_iw_container style_default clearfix" data-style="default">' +
								image +
								'<div class="wtbx_iw_content">' +
								title +
								address +
								description +
								'</div>' +
								'</div>';
						} else if ( options.locations[i].style === 'minimal' ) {
							content =
								'<div class="wtbx_iw_container style_minimal clearfix" data-style="minimal">' +
								'<div class="wtbx_iw_content">' +
								(title !== '' ? title : address ) +
								'</div>' +
								'</div>';
						} else if ( options.locations[i].style === 'colorful' ) {
							content =
								'<div class="wtbx_iw_container style_colorful clearfix" data-style="colorful">' +
								'<div class="wtbx_iw_content">' +
								(title !== '' ? title : address ) +
								'</div>' +
								'</div>';
						} else if ( options.locations[i].style === 'tile' ) {
							content =
								'<div class="wtbx_iw_container style_tile clearfix" data-style="tile">' +
								image +
								'<div class="wtbx_iw_content">' +
								title +
								address +
								description +
								'</div>' +
								'</div>';
						}

						SCAPE.googleMaps.addMarker(options, i, map, geocoder, infowindow, content);

						i++;

						if ( ! options.locations[i]) {
							clearInterval(geoInterval);
						}
					}, interval);
				}
			}
		},

		overlay: '',

		addMarker: function(options, i, map, geocoder, infowindow, content) {
			var address = options.locations[i].address;
			var loc		= {};
			var zoom, center;

			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == 'OK') {
					loc = results[0].geometry.location;

					var icon = options.locations[i].icon !== '' ? {url: options.locations[i].icon} : '';
					var marker = new google.maps.Marker({
						map: map,
						position: loc,
						animation: google.maps.Animation.DROP,
						icon: icon,
						title: options.locations[i].title,
						custom: options.locations[i].marker !== 'image' && options.locations[i].marker !== 'default'
					});

					if ( icon === '' && options.locations[i].marker !== 'default' ) {
						marker.setVisible(false);
					}

					if ( options.locations[i].style !== '' && ( options.locations[i].state === 'on_click' || options.locations[i].state === 'active_on_click' ) ) {
						google.maps.event.addListener(marker, 'click', function(e, custom) {
							infowindow.close();
							if ( !infowindow.getMap() ) {
								$(map.getDiv()).removeClass('infowindow_active marker_shift');
								infowindow.close();
								$(map.getDiv()).addClass('infowindow_active' + (!marker.get('custom') ? ' marker_shift' : ''));
								infowindow.setContent(content);
								infowindow.open(map, marker);
							}
						});

						google.maps.event.addListener(map, 'click', function() {
							infowindow.close();
							$(map.getDiv()).removeClass('infowindow_active marker_shift');
						});
					}

					if ( options.locations[i].style !== '' && options.locations[i].state === 'active' || options.locations[i].state === 'active_on_click' ) {
						$(map.getDiv()).addClass('infowindow_active' + (!marker.get('custom') ? ' marker_shift' : ''));
						infowindow.setContent(content);
						infowindow.open(map, marker);
					}

					if ( options.locations[i].style !== '' ) {
						google.maps.event.addListener(infowindow, 'domready', function(e, marker) {

							var iwOuter = $(map.getDiv()).find('.gm-style-iw').addClass('wtbx-infowindow');

							iwOuter.addClass('style_' + $(infowindow.content).data('style'));

							var iwCloseBtn = iwOuter.next();
							iwCloseBtn.addClass('wtbx_iw_close');

							setTimeout(function() {
								iwOuter.addClass('init');
							});
						});

						google.maps.event.addListener(infowindow, 'closeclick', function(){
							$(map.getDiv()).removeClass('infowindow_active marker_shift');
						});
					}

					if ( options.center === 'auto' ) {
						SCAPE.googleMaps.bounds.extend(loc);
						if ( i === options.locations.length-1 ) {
							map.fitBounds(SCAPE.googleMaps.bounds);
							map.panToBounds(SCAPE.googleMaps.bounds);
						}
					}

					var markerStyle = options.locations[i].marker;

					if ( 	markerStyle === 'circle' ||
						markerStyle === 'circle_border' ||
						markerStyle === 'circle_halo' ||
						markerStyle === 'circle_pulse' ||
						markerStyle === 'pin' ) {

						var overlay = new google.maps.OverlayView();
						overlay.draw = function() {
							var pixelOffset = overlay.getProjection().fromLatLngToDivPixel(marker.getPosition());

							$(map.getDiv()).find('.wtbx_gm_marker[data-id="'+i+'"]').remove();
							var $custom_marker = $('<div class="wtbx_gm_marker '+markerStyle+'" data-id="'+i+'"></div>')
								.css({
									'left': pixelOffset.x,
									'top': pixelOffset.y
								})
								.on('click', function(e) {
									SCAPE.stopEvent(e);
									new google.maps.event.trigger( marker, 'click', {custom: true} );
								});
							overlay.getPanes().overlayImage.appendChild($custom_marker[0]);
						};
						overlay.setMap(map);

					}

				} else {
					alert('Geocode was not successful for the following reason: ' + status);
				}
			});
		}

	};

})(jQuery);