<script setup>
import { Feature, Map, View } from 'ol';
import TileLayer from 'ol/layer/Tile';
import { OSM } from 'ol/source';
import 'ol/ol.css';
import { onMounted, ref } from 'vue';
import { fromLonLat, toLonLat } from 'ol/proj';
import InputGroup from '../InputGroup.vue';
import axios from 'axios';
import { Point } from 'ol/geom';
import Style from 'ol/style/Style';
import Icon from 'ol/style/Icon';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import locationIcon from '@/assets/location.svg';

const map = ref(null);
const mapContainer = ref(null);
const mapData = ref({
    search: ''
});
const nominatimData = ref([]);
const emit = defineEmits(['address-data']);

const handleMap = async (evt) => {
    const coords = toLonLat(evt.coordinate);
    const lon = coords[0].toFixed(6);
    const lat = coords[1].toFixed(6);

    const marker = new Feature({
        geometry: new Point(fromLonLat([lon, lat])),
        name: 'Моя метка'
    });

    marker.setStyle(
        new Style({
            image: new Icon({
                src: locationIcon,
                scale: 0.8
            })
        })
    );

    if (!window.vectorLayer) {
        window.vectorLayer = new VectorLayer({
            source: new VectorSource()
        });
        map.value.addLayer(window.vectorLayer);
    }

    window.vectorLayer.getSource().clear();
    window.vectorLayer.getSource().addFeature(marker);

    const response = await axios.get(
        'https://nominatim.openstreetmap.org/reverse?format=json&addressdetails=1&lat=' +
            lat +
            '&lon=' +
            lon
    );

    nominatimData.value = response.data;
    emit('address-data', nominatimData.value);
    zoomToAddress([response.data.lon, response.data.lat]);
};

const action = async () => {
    try {
        const response = await axios.get(
            'https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=' +
                mapData.value.search
        );

        nominatimData.value = response.data[0];

        emit('address-data', nominatimData.value);
        zoomToAddress([response.data[0].lon, response.data[0].lat]);
    } catch (err) {
        console.log(err);
    }
};

const zoomToAddress = (coordinates, zoomLevel = 18) => {
    const projectedCoords = fromLonLat(coordinates);

    map.value.getView().animate({
        center: projectedCoords,
        zoom: zoomLevel,
        duration: 1000
    });

    const marker = new Feature({
        geometry: new Point(projectedCoords),
        name: 'Моя метка'
    });

    marker.setStyle(
        new Style({
            image: new Icon({
                src: locationIcon,
                scale: 0.8
            })
        })
    );

    if (!window.vectorLayer) {
        window.vectorLayer = new VectorLayer({
            source: new VectorSource()
        });
        map.value.addLayer(window.vectorLayer);
    }

    window.vectorLayer.getSource().clear();
    window.vectorLayer.getSource().addFeature(marker);
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

    map.value.on('click', handleMap);
};

onMounted(() => {
    initMap();
});
</script>

<template>
    <div class="flex border border-gray-300">
        <div class="max-w-[250px] w-full py-2 px-3">
            <InputGroup
                v-model="mapData.search"
                label="Введите адрес"
                placeholder="Ростов-на-Дону, ул. Малиновского ..."
            />

            <button
                type="button"
                v-on:click="action()"
                class="text-sm bg-[#C1E0FF] text-white py-[6px] px-[9px] rounded-[6px] w-full hover:cursor-pointer mt-2"
            >
                <div class="flex items-center justify-center gap-[10px]">
                    <div class="text-[#357CC5]">Найти</div>
                </div>
            </button>
        </div>
        <div ref="mapContainer" class="w-full h-[400px]"></div>
    </div>
</template>
