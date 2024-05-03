import { ref } from "vue"

export default function mapsMaster(){
    const isLoading = ref(false)
    const placesArray = ref({
        school: [],
        supermarket: [],
        bus_stop: [],
    })
    const distancesArray = ref({
        school: [],
        supermarket: [],
        bus_stop: [],
    })
    let map;

    // const nearbySearch = (lat, lng, type) => {
    //     console.log(import.meta.env.VITE_GOOGLE_MAPS_API_KEY)

    //     if (isLoading.value) return
    //     isLoading.value = true
        
    //     const request = ref(`https://maps.googleapis.com/maps/api/place/nearbysearch/json?keyword=cruise&location=${lat}${lng}&radius=1500&type=${type}&key=${import.meta.env.VITE_GOOGLE_MAPS_API_KEY}`)

    //     axios.get(request.value)
    //     .then(response => {
    //         console.log(response.data)
    //     })
    //     .catch(error => console.log(error))
    //     .finally(isLoading.value = false)
    // }

    // const initMap = async (lat, lng, zoom, marker, markerTitle) => {
    const initMap = async (maParams) => {
        const { Map } = await google.maps.importLibrary("maps");

        // let position = { lat: +lat, lng: +lng }

        map = new Map(document.getElementById("map"), {
            center: maParams.map.position,
            zoom: maParams.map.zoom,
            title: maParams.marker.title,
            mapId: "map_default",
        });

        if (maParams.marker.enabled) {
            if (maParams.marker.targetFunction == `setMarker`) {
                setMarker(maParams.map.position, map)
            }
            if (maParams.marker.targetFunction == `setBigMarker`) {
                setBigMarker(maParams.map.position, map)
            }
        }

        if (maParams.places.enabled) {
            nearbySearch(maParams.map.position, ["school"])
            nearbySearch(maParams.map.position, ["supermarket"])
            nearbySearch(maParams.map.position, ["bus_stop"])
        }
    }

    async function setMarker(position, map) {
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
        const marker = new AdvancedMarkerElement({
            map: map,
            position: position,
        });
    }

    async function setBigMarker(position, map) {
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
        const marker = new AdvancedMarkerElement({
            map: map,
            position: position,
            content: new PinElement({
                scale: 1.5,
                glyphColor: "#362c41",
                background: "#703680",
                borderColor: "#a058f1",
            }).element
        });
    }

    async function nearbySearch(position, primaryTypes) {
        const { Place, SearchNearbyRankPreference } = await google.maps.importLibrary(
            "places",
        );
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

        let center = new google.maps.LatLng(position);
        const request = {
            fields: ["displayName", "location", "editorialSummary", "formattedAddress", "types"],
            locationRestriction: {
                center: center,
                radius: 1500,
            },

            // includedPrimaryTypes: ["school", "supermarket", "bus_stop"],
            includedPrimaryTypes: primaryTypes,
            maxResultCount: 3,
            rankPreference: SearchNearbyRankPreference.POPULARITY,
            language: "en-UK",
            region: "ke",
        };

        const { places } = await Place.searchNearby(request);

        if (places.length) {
            // console.log(places);

            const { LatLngBounds } = await google.maps.importLibrary("core");
            const bounds = new LatLngBounds();
            
            places.forEach((place) => {
                const markerView = new AdvancedMarkerElement({
                    map,
                    position: place.location,
                    title: place.displayName,
                });

                bounds.extend(place.location);
                // console.log(place);
                if (primaryTypes.includes('school')) {
                    if (place.types.includes('school') && placesArray.value.school.length < 3) {
                        placesArray.value.school.push(place)
                        nearbySearchDistances(position, place.location, 'school', place.displayName)
                    }
                }
                if (primaryTypes.includes('supermarket')) {
                    if (place.types.includes('supermarket') && placesArray.value.supermarket.length < 3) {
                        placesArray.value.supermarket.push(place)
                        nearbySearchDistances(position, place.location, 'supermarket', place.displayName)
                    }
                }
                if (primaryTypes.includes('bus_stop')) {
                    if (place.types.includes('bus_stop') && placesArray.value.bus_stop.length < 3){
                        placesArray.value.bus_stop.push(place)
                        nearbySearchDistances(position, place.location, 'bus_stop', place.displayName)
                    }
                }
            });
            map.fitBounds(bounds);
        } else {
            // console.log("No results");
        }
    }

    async function nearbySearchDistances(orig, dest, type, place) {
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
            {
                origins: [orig],
                destinations: [dest],
                travelMode: 'WALKING',
            }, (response, status) => {
                if (status == 'OK') {
                    var origins = response.originAddresses;
                    var destinations = response.destinationAddresses;

                    for (var i = 0; i < origins.length; i++) {
                        var results = response.rows[i].elements;
                        for (var j = 0; j < results.length; j++) {
                            var element = results[j];
                            var distance = element.distance.text;
                            if (type == 'school') {
                                distancesArray.value.school.push([place, element.distance.text])
                            }
                            if (type == 'supermarket') {
                                distancesArray.value.supermarket.push([place, element.distance.text])
                            }
                            if (type == 'bus_stop') {
                                distancesArray.value.bus_stop.push([place, element.distance.text])
                            }
                            var duration = element.duration.text;
                            var from = origins[i];
                            var to = destinations[j];
                        }
                    }
                }
            });
    }

    return {
        isLoading, 
        nearbySearch, 
        initMap, 
        map, 
        placesArray, 
        distancesArray, 
    }
}