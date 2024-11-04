import AbstractMapController from '@symfony/ux-map';
import type { Point, MarkerDefinition, PolygonDefinition, PolylineDefinition } from '@symfony/ux-map';
import 'leaflet/dist/leaflet.min.css';
import * as L from 'leaflet';
import type { MapOptions as LeafletMapOptions, MarkerOptions, PopupOptions, PolylineOptions as PolygonOptions, PolylineOptions } from 'leaflet';
type MapOptions = Pick<LeafletMapOptions, 'center' | 'zoom'> & {
    tileLayer: {
        url: string;
        attribution: string;
        options: Record<string, unknown>;
    };
};
export default class extends AbstractMapController<MapOptions, typeof L.Map, MarkerOptions, typeof L.Marker, PopupOptions, typeof L.Popup, PolygonOptions, typeof L.Polygon, PolylineOptions, typeof L.Polyline> {
    connect(): void;
    protected dispatchEvent(name: string, payload?: Record<string, unknown>): void;
    protected doCreateMap({ center, zoom, options, }: {
        center: Point | null;
        zoom: number | null;
        options: MapOptions;
    }): L.Map;
    protected doCreateMarker(definition: MarkerDefinition<typeof L.Marker, typeof L.Popup>): L.Marker;
    protected removeMarker(marker: L.Marker): void;
    protected doCreatePolygon(definition: PolygonDefinition<typeof L.Polygon, typeof L.Popup>): L.Polygon;
    protected removePolygon(polygon: L.Polygon): void;
    protected doCreatePolyline(definition: PolylineDefinition): L.Polyline;
    protected removePolyline(polyline: L.Polyline): void;
    protected doCreateInfoWindow({ definition, element, }: {
        definition: MarkerDefinition<typeof L.Marker, typeof L.Popup>['infoWindow'];
        element: L.Marker;
    } | {
        definition: PolygonDefinition<typeof L.Polygon, typeof L.Popup>['infoWindow'];
        element: L.Polygon;
    } | {
        definition: PolylineDefinition<typeof L.Polyline, typeof L.Popup>['infoWindow'];
        element: L.Polyline;
    }): L.Popup;
    protected doFitBoundsToMarkers(): void;
    centerValueChanged(): void;
    zoomValueChanged(): void;
}
export {};
