import { Controller } from '@hotwired/stimulus';
import 'leaflet/dist/leaflet.min.css';
import * as L from 'leaflet';

class default_1 extends Controller {
    constructor() {
        super(...arguments);
        this.markers = new Map();
        this.infoWindows = [];
        this.polygons = new Map();
        this.polylines = new Map();
    }
    connect() {
        const options = this.optionsValue;
        this.dispatchEvent('pre-connect', { options });
        this.map = this.doCreateMap({ center: this.centerValue, zoom: this.zoomValue, options });
        this.markersValue.forEach((marker) => this.createMarker(marker));
        this.polygonsValue.forEach((polygon) => this.createPolygon(polygon));
        this.polylinesValue.forEach((polyline) => this.createPolyline(polyline));
        if (this.fitBoundsToMarkersValue) {
            this.doFitBoundsToMarkers();
        }
        this.dispatchEvent('connect', {
            map: this.map,
            markers: [...this.markers.values()],
            polygons: [...this.polygons.values()],
            polylines: [...this.polylines.values()],
            infoWindows: this.infoWindows,
        });
    }
    createMarker(definition) {
        this.dispatchEvent('marker:before-create', { definition });
        const marker = this.doCreateMarker(definition);
        this.dispatchEvent('marker:after-create', { marker });
        marker['@id'] = definition['@id'];
        this.markers.set(definition['@id'], marker);
        return marker;
    }
    createPolygon(definition) {
        this.dispatchEvent('polygon:before-create', { definition });
        const polygon = this.doCreatePolygon(definition);
        this.dispatchEvent('polygon:after-create', { polygon });
        polygon['@id'] = definition['@id'];
        this.polygons.set(definition['@id'], polygon);
        return polygon;
    }
    createPolyline(definition) {
        this.dispatchEvent('polyline:before-create', { definition });
        const polyline = this.doCreatePolyline(definition);
        this.dispatchEvent('polyline:after-create', { polyline });
        polyline['@id'] = definition['@id'];
        this.polylines.set(definition['@id'], polyline);
        return polyline;
    }
    createInfoWindow({ definition, element, }) {
        this.dispatchEvent('info-window:before-create', { definition, element });
        const infoWindow = this.doCreateInfoWindow({ definition, element });
        this.dispatchEvent('info-window:after-create', { infoWindow, element });
        this.infoWindows.push(infoWindow);
        return infoWindow;
    }
    markersValueChanged() {
        if (!this.map) {
            return;
        }
        this.markers.forEach((marker) => {
            if (!this.markersValue.find((m) => m['@id'] === marker['@id'])) {
                this.removeMarker(marker);
                this.markers.delete(marker['@id']);
            }
        });
        this.markersValue.forEach((marker) => {
            if (!this.markers.has(marker['@id'])) {
                this.createMarker(marker);
            }
        });
        if (this.fitBoundsToMarkersValue) {
            this.doFitBoundsToMarkers();
        }
    }
    polygonsValueChanged() {
        if (!this.map) {
            return;
        }
        this.polygons.forEach((polygon) => {
            if (!this.polygonsValue.find((p) => p['@id'] === polygon['@id'])) {
                this.removePolygon(polygon);
                this.polygons.delete(polygon['@id']);
            }
        });
        this.polygonsValue.forEach((polygon) => {
            if (!this.polygons.has(polygon['@id'])) {
                this.createPolygon(polygon);
            }
        });
    }
    polylinesValueChanged() {
        if (!this.map) {
            return;
        }
        this.polylines.forEach((polyline) => {
            if (!this.polylinesValue.find((p) => p['@id'] === polyline['@id'])) {
                this.removePolyline(polyline);
                this.polylines.delete(polyline['@id']);
            }
        });
        this.polylinesValue.forEach((polyline) => {
            if (!this.polylines.has(polyline['@id'])) {
                this.createPolyline(polyline);
            }
        });
    }
}
default_1.values = {
    providerOptions: Object,
    center: Object,
    zoom: Number,
    fitBoundsToMarkers: Boolean,
    markers: Array,
    polygons: Array,
    polylines: Array,
    options: Object,
};

class map_controller extends default_1 {
    connect() {
        L.Marker.prototype.options.icon = L.divIcon({
            html: '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" fill-rule="evenodd" stroke-linecap="round" clip-rule="evenodd" viewBox="0 0 500 820"><defs><linearGradient id="__sf_ux_map_gradient_marker_fill" x1="0" x2="1" y1="0" y2="0" gradientTransform="matrix(0 -37.57 37.57 0 416.45 541)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#126FC6"/><stop offset="1" stop-color="#4C9CD1"/></linearGradient><linearGradient id="__sf_ux_map_gradient_marker_border" x1="0" x2="1" y1="0" y2="0" gradientTransform="matrix(0 -19.05 19.05 0 414.48 522.49)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2E6C97"/><stop offset="1" stop-color="#3883B7"/></linearGradient></defs><circle cx="252.31" cy="266.24" r="83.99" fill="#fff"/><path fill="url(#__sf_ux_map_gradient_marker_fill)" stroke="url(#__sf_ux_map_gradient_marker_border)" stroke-width="1.1" d="M416.54 503.61c-6.57 0-12.04 5.7-12.04 11.87 0 2.78 1.56 6.3 2.7 8.74l9.3 17.88 9.26-17.88c1.13-2.43 2.74-5.79 2.74-8.74 0-6.18-5.38-11.87-11.96-11.87Zm0 7.16a4.69 4.69 0 1 1-.02 9.4 4.69 4.69 0 0 1 .02-9.4Z" transform="translate(-7889.1 -9807.44) scale(19.54)"/></svg>',
            iconSize: [25, 41],
            iconAnchor: [12.5, 41],
            popupAnchor: [0, -41],
            className: '',
        });
        super.connect();
    }
    dispatchEvent(name, payload = {}) {
        this.dispatch(name, {
            prefix: 'ux:map',
            detail: {
                ...payload,
                L,
            },
        });
    }
    doCreateMap({ center, zoom, options, }) {
        const map = L.map(this.element, {
            ...options,
            center: center === null ? undefined : center,
            zoom: zoom === null ? undefined : zoom,
        });
        L.tileLayer(options.tileLayer.url, {
            attribution: options.tileLayer.attribution,
            ...options.tileLayer.options,
        }).addTo(map);
        return map;
    }
    doCreateMarker(definition) {
        const { '@id': _id, position, title, infoWindow, extra, rawOptions = {}, ...otherOptions } = definition;
        const marker = L.marker(position, { title, ...otherOptions, ...rawOptions }).addTo(this.map);
        if (infoWindow) {
            this.createInfoWindow({ definition: infoWindow, element: marker });
        }
        return marker;
    }
    removeMarker(marker) {
        marker.remove();
    }
    doCreatePolygon(definition) {
        const { '@id': _id, points, title, infoWindow, rawOptions = {} } = definition;
        const polygon = L.polygon(points, { ...rawOptions }).addTo(this.map);
        if (title) {
            polygon.bindPopup(title);
        }
        if (infoWindow) {
            this.createInfoWindow({ definition: infoWindow, element: polygon });
        }
        return polygon;
    }
    removePolygon(polygon) {
        polygon.remove();
    }
    doCreatePolyline(definition) {
        const { '@id': _id, points, title, infoWindow, rawOptions = {} } = definition;
        const polyline = L.polyline(points, { ...rawOptions }).addTo(this.map);
        if (title) {
            polyline.bindPopup(title);
        }
        if (infoWindow) {
            this.createInfoWindow({ definition: infoWindow, element: polyline });
        }
        return polyline;
    }
    removePolyline(polyline) {
        polyline.remove();
    }
    doCreateInfoWindow({ definition, element, }) {
        const { headerContent, content, rawOptions = {}, ...otherOptions } = definition;
        element.bindPopup([headerContent, content].filter((x) => x).join('<br>'), { ...otherOptions, ...rawOptions });
        if (definition.opened) {
            element.openPopup();
        }
        const popup = element.getPopup();
        if (!popup) {
            throw new Error('Unable to get the Popup associated with the element.');
        }
        return popup;
    }
    doFitBoundsToMarkers() {
        if (this.markers.length === 0) {
            return;
        }
        this.map.fitBounds(this.markers.map((marker) => {
            const position = marker.getLatLng();
            return [position.lat, position.lng];
        }));
    }
    centerValueChanged() {
        if (this.map) {
            this.map.setView(this.centerValue, this.zoomValue);
        }
    }
    zoomValueChanged() {
        if (this.map) {
            this.map.setZoom(this.zoomValue);
        }
    }
}

export { map_controller as default };
