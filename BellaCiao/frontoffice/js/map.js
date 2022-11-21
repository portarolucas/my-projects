// Create the script tag, set the appropriate attributes
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyASefJ6PaNO-Cj0jeypuFMIHmTUdJKHaIc&callback=initMap';
script.async = true;


var map;
// Attach your callback function to the `window` object
window.initMap = function() {
  // JS API is loaded and available
  var stylesArray = [
    { elementType: "geometry", stylers: [{ color: "#ebe3cd" }] },
    { elementType: "labels.text.fill", stylers: [{ color: "#523735" }] },
    { elementType: "labels.text.stroke", stylers: [{ color: "#f5f1e6" }] },
    {
      featureType: "administrative",
      elementType: "geometry.stroke",
      stylers: [{ color: "#c9b2a6" }],
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "geometry.stroke",
      stylers: [{ color: "#dcd2be" }],
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "labels.text.fill",
      stylers: [{ color: "#ae9e90" }],
    },
    {
      featureType: "landscape.natural",
      elementType: "geometry",
      stylers: [{ color: "#dfd2ae" }],
    },
    {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [{ color: "#93817c" }],
    },
    {
      featureType: "poi.park",
      elementType: "geometry.fill",
      stylers: [{ color: "#a5b076" }],
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [{ color: "#447530" }],
    },
    {
      featureType: "road",
      elementType: "geometry",
      stylers: [{ color: "#f5f1e6" }],
    },
    {
      featureType: "road.arterial",
      elementType: "geometry",
      stylers: [{ color: "#fdfcf8" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [{ color: "#f8c967" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry.stroke",
      stylers: [{ color: "#e9bc62" }],
    },
    {
      featureType: "road.highway.controlled_access",
      elementType: "geometry",
      stylers: [{ color: "#e98d58" }],
    },
    {
      featureType: "road.highway.controlled_access",
      elementType: "geometry.stroke",
      stylers: [{ color: "#db8555" }],
    },
    {
      featureType: "road.local",
      elementType: "labels.text.fill",
      stylers: [{ color: "#806b63" }],
    },
    {
      featureType: "transit.line",
      elementType: "geometry",
      stylers: [{ color: "#dfd2ae" }],
    },
    {
      featureType: "transit.line",
      elementType: "labels.text.fill",
      stylers: [{ color: "#8f7d77" }],
    },
    {
      featureType: "transit.line",
      elementType: "labels.text.stroke",
      stylers: [{ color: "#ebe3cd" }],
    },
    {
      featureType: "water",
      elementType: "geometry.fill",
      stylers: [{ color: "#b9d3c2" }],
    },
    {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [{ color: "#92998d" }],
    },
    {
      featureType: "transit.station",
      elementType: "all",
      stylers: [{ visibility: "off" }],
    },
    {
      featureType: "poi",
      elementType: "all",
      stylers: [{ visibility: "off" }],
    },
  ]

  const pizzeriaLoc = { lat: 49.164231, lng: 5.86613 }
  const pizzaIconUri = './img/pizza_map.png'

  map = new google.maps.Map(document.getElementById("map"), {
    center: pizzeriaLoc,
    zoom: 16,
    styles: stylesArray,
    disableDefaultUI: true,
    gestureHandling: 'greedy',

  });

  google.maps.event.addListenerOnce(map, 'idle', function(){
    window.setTimeout(() => {
      addMarkerWithAnimation()
    }, 500);
  });

  let marker;
  function addMarkerWithAnimation() {
    marker = new google.maps.Marker({
      position: pizzeriaLoc,
      map,
      text: "Bella Ciao - Pizzeria",
      icon: {
        url: pizzaIconUri,
        scaledSize: new google.maps.Size(50, 50)
      },
      animation: google.maps.Animation.DROP,
    })

    const contentString =
      '<div id="content">' +
      '<h1 id="firstHeading" class="firstHeading">Pizzeria Bella Ciao</h1>' +
      '<div id="bodyContent">' +
      "<p>Jarny, 27 rue de verdun</p>" +
      "</div>" +
      "</div>";

      const infowindow = new google.maps.InfoWindow({
        content: contentString,
      });

      marker.addListener("click", () => {
        infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
        });
      });
  }

};

// Append the 'script' element to 'head'
document.head.appendChild(script);
