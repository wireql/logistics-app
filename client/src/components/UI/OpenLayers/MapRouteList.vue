<script setup>
import { Feature, Map, View } from 'ol';
import TileLayer from 'ol/layer/Tile';
import { OSM, Source, Vector } from 'ol/source';
import 'ol/ol.css';
import { onMounted, ref } from 'vue';
import { fromLonLat } from 'ol/proj';
import Style from 'ol/style/Style';
import GeoJSON from 'ol/format/GeoJSON';
import Stroke from 'ol/style/Stroke';
import VectorLayer from 'ol/layer/Vector';
import { Point } from 'ol/geom';
import { Circle as CircleStyle, Icon } from 'ol/style';
import locationIcon from '@/assets/location.svg';

const map = ref(null);
const mapContainer = ref(null);
const props = defineProps({
    data: {
        type: Array,
        default: []
    }
});

const getRoute = async (coords) => {
    const osrmUrl = `http://router.project-osrm.org/route/v1/driving/${coords}?overview=full&geometries=geojson`;

    try {
        const response = await fetch(osrmUrl);
        const data = await response.json();

        if (data.routes && data.routes.length > 0) {
            const route = data.routes[0];

            showRoute(route.geometry);
            showMarkers(coords);
        }
    } catch (error) {
        console.error('Ошибка при получении маршрута:', error);
    }
};

const showRoute = (geometry) => {
    if (window.routeLayer) {
        map.value.removeLayer(window.routeLayer);
    }

    const routeFeature = new GeoJSON().readFeature(geometry, {
        dataProjection: 'EPSG:4326',
        featureProjection: 'EPSG:3857'
    });

    const routeSource = new Vector({
        features: [routeFeature]
    });

    window.routeLayer = new VectorLayer({
        source: routeSource,
        style: new Style({
            stroke: new Stroke({
                color: 'blue',
                width: 4
            })
        })
    });

    map.value.addLayer(window.routeLayer);

    const routeExtent = routeSource.getExtent();
    map.value.getView().fit(routeExtent, {
        padding: [50, 50, 50, 50],
        duration: 1000,
        maxZoom: 15
    });
};

const showMarkers = (coords) => {
    if (window.markersLayer) {
        map.value.removeLayer(window.markersLayer);
    }

    // Создаем массив фич (маркеров) для всех точек
    const markerFeatures = coords.split(';').map((coord) => {
        const [lon, lat] = coord.split(',').map(Number);
        const marker = new Feature({
            geometry: new Point(fromLonLat([lon, lat]))
        });

        marker.setStyle(
            new Style({
                image: new Icon({
                    src: locationIcon,
                    scale: 0.8,
                    anchor: [0.5, 1]
                })
            })
        );

        return marker;
    });

    const markersSource = new Vector({
        features: markerFeatures
    });

    window.markersLayer = new VectorLayer({
        source: markersSource
    });

    map.value.addLayer(window.markersLayer);
};

const initMap = () => {
    map.value = new Map({
        target: mapContainer.value,
        layers: [
            new TileLayer({
                source: new OSM()
            })
        ],
        view: new View({
            center: fromLonLat([39.7188, 47.222115]),
            zoom: 12
        })
    });

    // map.value.on('click', handleMap);
};

onMounted(() => {
    initMap();

    const pickups = props.data.filter(
        (item) => item.route_point_category_id === 1
    );
    const deliveries = props.data.filter(
        (item) => item.route_point_category_id === 2
    );
    const sortedPoints = [...pickups, ...deliveries];

    const coords = sortedPoints
        .map((p) => `${p.address.longitude},${p.address.latitude}`)
        .join(';');

    getRoute(coords);
});
</script>

<template>
    <div class="flex border border-gray-300">
        <div ref="mapContainer" class="w-full h-[400px]"></div>
    </div>
</template>
