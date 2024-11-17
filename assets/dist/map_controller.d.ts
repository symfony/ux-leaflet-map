import AbstractMapController from '@symfony/ux-map';
import type { Point, MarkerDefinition, PolygonDefinition } from '@symfony/ux-map';
import 'leaflet/dist/leaflet.min.css';
import * as L from 'leaflet';
import type { MapOptions as LeafletMapOptions, MarkerOptions, PopupOptions, PolygonOptions } from 'leaflet';
type MapOptions = Pick<LeafletMapOptions, 'center' | 'zoom'> & {
    tileLayer: {
        url: string;
        attribution: string;
        options: Record<string, unknown>;
    };
};
export default class extends AbstractMapController<MapOptions, typeof L.Map, MarkerOptions, typeof L.Marker, PopupOptions, typeof L.Popup, PolygonOptions, typeof L.Polygon> {
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
    protected doCreateInfoWindow({ definition, element, }: {
        definition: MarkerDefinition<typeof L.Marker, typeof L.Popup>;
        element: L.Marker;
    } | {
        definition: PolygonDefinition<typeof L.Polygon, typeof L.Popup>;
        element: L.Polygon;
    }): L.Popup;
    protected doFitBoundsToMarkers(): void;
    centerValueChanged(): void;
    zoomValueChanged(): void;
}
export {};
