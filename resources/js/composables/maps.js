let map;

async function initMap() {
    const { Map } = await google.maps.importLibrary("maps");

    map = new Map(document.getElementById("map"), {
        center: { lat: 0.241829, lng: 37.815589 },
        zoom: 8,
    });
}

initMap();