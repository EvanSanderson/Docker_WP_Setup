<section id="module-<?php echo $i; ?>" class="map-module">
	<div id="map" style="width: 100%; height:75vh;"></div>

	<?php $projects = array();
	$projectsArgs = array(
	  'post_type'           => 'location',
	  'posts_per_page'      => -1,
	);
	$projectslist = new WP_Query($projectsArgs);

	while ( $projectslist->have_posts() ) : $projectslist->the_post();
		$project_name = get_the_title();
		$project_link = get_the_permalink();
		$lat = get_field('latitude');
		$long = get_field('longitude');
		//$project_size = get_field('project_size');
		//$service = get_field('service_provided');
		$location = get_field('city').", ".get_field('state');
		$projects[]=array($project_name,$lat,$long,$location,$project_link);

	endwhile;

	?>

	<script>

	var locations = <?php echo json_encode($projects); ?>;

    var myStyle = [
 {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "elementType": "geometry.fill",
    "stylers": [
      {
        "saturation": -90
      },
      {
        "lightness": -10
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#523735"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "administrative",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#c9b2a6"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#dcd2be"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#ae9e90"
      }
    ]
  },
  {
    "featureType": "landscape.man_made",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#d5cfce"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#d5cfce"
      }
    ]
  },
  {
    "featureType": "landscape.natural.landcover",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#d5cfce"
      }
    ]
  },
  {
    "featureType": "landscape.natural.terrain",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#d5cfce"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#babdbe"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#93817c"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#a5b076"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#447530"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#47ff45"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#fdfcf8"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f8c967"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#56ff6a"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#e9bc62"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e98d58"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#64ff5c"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#db8555"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#806b63"
      }
    ]
  },
  {
    "featureType": "transit",
    "stylers": [
      {
        "color": "#d5cfce"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#d5cfce"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8f7d77"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#91c3ca"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#92998d"
      }
    ]
  }
	];

    var map = new google.maps.Map(document.getElementById('map'), {
       mapTypeControlOptions: {
         mapTypeIds: ['mystyle', google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.TERRAIN]
       },
       zoom: 10,
      center: new google.maps.LatLng(38.9, -77),
      scrollwheel: false,
      navigationControl: false,
      mapTypeControl: false,
       mapTypeId: 'mystyle'
     });

     map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, { name: 'My Style' }));

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    var icon = {

	    path: "M305.749908,291 C295.395272,291 287,299.39366 287,309.749908 C287,312.650431 287.659176,315.400369 288.836759,317.850601 C288.90253,317.989614 305.749908,351 305.749908,351 L322.459885,318.260902 C323.764029,315.708278 324.499817,312.815226 324.499817,309.749908 C324.499817,299.39366 316.106157,291 305.749908,291 L305.749908,291 Z M305.749908,321 C299.536951,321 294.499817,315.960523 294.499817,309.749908 C294.499817,303.539294 299.536951,298.499817 305.749908,298.499817 C311.960523,298.499817 317,303.539294 317,309.749908 C317,315.960523 311.960523,321 305.749908,321 L305.749908,321 Z",
	    fillColor: '#AC2EFF',
	    strokeColor: '#AC2EFF',
	    fillOpacity: 1,
	    size: new google.maps.Size(38,60),
	    origin: new google.maps.Point(287, 291),
        anchor: new google.maps.Point(294,351),
        scale:1,
	}
    
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        icon: icon,
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
        	var html = "<div style='font-family:stevie-sans, sans-serif;color:#777;padding:1rem 1rem 2rem;'><a href='"+ locations[i][6] +"' style='font-size:1.5rem; font-weight:bold;'>" + locations[i][0] + "</a></b><br/></b>" ;
            infowindow.setContent(html);
            infowindow.open(map, marker, html);
            marker.setIcon(activeIcon); 
          //infowindow.setContent(locations[i][0],locations[i][3]);
          //infowindow.open(map, marker);
        }
      })(marker, i));
    }

    </script>

	
</section>
<?php wp_reset_query(); ?>