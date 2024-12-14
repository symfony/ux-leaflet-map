<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Map\Bridge\Leaflet\Tests;

use Symfony\UX\Map\Bridge\Leaflet\Renderer\LeafletRenderer;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Polygon;
use Symfony\UX\Map\Polyline;
use Symfony\UX\Map\Test\RendererTestCase;
use Symfony\UX\StimulusBundle\Helper\StimulusHelper;

class LeafletRendererTest extends RendererTestCase
{
    public function provideTestRenderMap(): iterable
    {
        $map = (new Map())
            ->center(new Point(48.8566, 2.3522))
            ->zoom(12);

        $marker1 = new Marker(position: new Point(48.8566, 2.3522), title: 'Paris', id: 'marker1');
        $marker2 = new Marker(position: new Point(48.8566, 2.3522), title: 'Lyon', infoWindow: new InfoWindow(content: 'Lyon'), id: 'marker2');
        $marker3 = new Marker(position: new Point(45.8566, 2.3522), title: 'Dijon', id: 'marker3');

        yield 'simple map' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[]" data-symfony--ux-leaflet-map--map-polylines-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (clone $map),
        ];

        yield 'with custom attributes' => [
            'expected_render' => '<div data-controller="my-custom-controller symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[]" data-symfony--ux-leaflet-map--map-polylines-value="[]" class="map"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (clone $map),
            'attributes' => ['data-controller' => 'my-custom-controller', 'class' => 'map'],
        ];
        yield 'with markers and infoWindows' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[{&quot;position&quot;:{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},&quot;title&quot;:&quot;Paris&quot;,&quot;infoWindow&quot;:null,&quot;extra&quot;:[],&quot;id&quot;:&quot;marker1&quot;,&quot;@id&quot;:&quot;ff8e1883540bc717&quot;},{&quot;position&quot;:{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},&quot;title&quot;:&quot;Lyon&quot;,&quot;infoWindow&quot;:{&quot;headerContent&quot;:null,&quot;content&quot;:&quot;Lyon&quot;,&quot;position&quot;:null,&quot;opened&quot;:false,&quot;autoClose&quot;:true,&quot;extra&quot;:[]},&quot;extra&quot;:[],&quot;id&quot;:null,&quot;@id&quot;:&quot;adcbe35d50b3c983&quot;}]" data-symfony--ux-leaflet-map--map-polygons-value="[]" data-symfony--ux-leaflet-map--map-polylines-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (new Map())
                ->center(new Point(48.8566, 2.3522))
                ->zoom(12)
                ->addMarker($marker1)
                ->addMarker(new Marker(position: new Point(48.8566, 2.3522), title: 'Lyon', infoWindow: new InfoWindow(content: 'Lyon'))),
        ];

        yield 'with all markers removed' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[]" data-symfony--ux-leaflet-map--map-polylines-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (new Map())
                ->center(new Point(48.8566, 2.3522))
                ->zoom(12)
                ->addMarker($marker1)
                ->addMarker($marker2)
                ->removeMarker($marker1)
                ->removeMarker($marker2),
        ];

        yield 'with marker remove and new ones added' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[{&quot;position&quot;:{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},&quot;title&quot;:&quot;Paris&quot;,&quot;infoWindow&quot;:null,&quot;extra&quot;:[],&quot;id&quot;:&quot;marker1&quot;,&quot;@id&quot;:&quot;ff8e1883540bc717&quot;},{&quot;position&quot;:{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},&quot;title&quot;:&quot;Lyon&quot;,&quot;infoWindow&quot;:{&quot;headerContent&quot;:null,&quot;content&quot;:&quot;Lyon&quot;,&quot;position&quot;:null,&quot;opened&quot;:false,&quot;autoClose&quot;:true,&quot;extra&quot;:[]},&quot;extra&quot;:[],&quot;id&quot;:&quot;marker2&quot;,&quot;@id&quot;:&quot;9514c2b94def6c52&quot;}]" data-symfony--ux-leaflet-map--map-polygons-value="[]" data-symfony--ux-leaflet-map--map-polylines-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (new Map())
                ->center(new Point(48.8566, 2.3522))
                ->zoom(12)
                ->addMarker($marker3)
                ->removeMarker($marker3)
                ->addMarker($marker1)
                ->addMarker($marker2),
        ];

        yield 'with polygons and infoWindows' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[{&quot;points&quot;:[{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}],&quot;title&quot;:null,&quot;infoWindow&quot;:null,&quot;extra&quot;:[],&quot;id&quot;:&quot;polygon1&quot;,&quot;@id&quot;:&quot;35bfa920335b849d&quot;},{&quot;points&quot;:[{&quot;lat&quot;:1.1,&quot;lng&quot;:2.2},{&quot;lat&quot;:3.3,&quot;lng&quot;:4.4},{&quot;lat&quot;:5.5,&quot;lng&quot;:6.6}],&quot;title&quot;:null,&quot;infoWindow&quot;:{&quot;headerContent&quot;:null,&quot;content&quot;:&quot;Polygon&quot;,&quot;position&quot;:null,&quot;opened&quot;:false,&quot;autoClose&quot;:true,&quot;extra&quot;:[]},&quot;extra&quot;:[],&quot;id&quot;:&quot;polygon2&quot;,&quot;@id&quot;:&quot;7be1fe9f10489d73&quot;}]" data-symfony--ux-leaflet-map--map-polylines-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (new Map())
                ->center(new Point(48.8566, 2.3522))
                ->zoom(12)
                ->addPolygon(new Polygon(points: [new Point(48.8566, 2.3522), new Point(48.8566, 2.3522), new Point(48.8566, 2.3522)], id: 'polygon1'))
                ->addPolygon(new Polygon(points: [new Point(1.1, 2.2), new Point(3.3, 4.4), new Point(5.5, 6.6)], infoWindow: new InfoWindow(content: 'Polygon'), id: 'polygon2')),
        ];

        yield 'with polylines and infoWindows' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[]" data-symfony--ux-leaflet-map--map-polylines-value="[{&quot;points&quot;:[{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}],&quot;title&quot;:null,&quot;infoWindow&quot;:null,&quot;extra&quot;:[],&quot;id&quot;:&quot;polyline1&quot;,&quot;@id&quot;:&quot;823f6ee5acdb5db3&quot;},{&quot;points&quot;:[{&quot;lat&quot;:1.1,&quot;lng&quot;:2.2},{&quot;lat&quot;:3.3,&quot;lng&quot;:4.4},{&quot;lat&quot;:5.5,&quot;lng&quot;:6.6}],&quot;title&quot;:null,&quot;infoWindow&quot;:{&quot;headerContent&quot;:null,&quot;content&quot;:&quot;Polyline&quot;,&quot;position&quot;:null,&quot;opened&quot;:false,&quot;autoClose&quot;:true,&quot;extra&quot;:[]},&quot;extra&quot;:[],&quot;id&quot;:&quot;polyline2&quot;,&quot;@id&quot;:&quot;77fb0e390b5e91f1&quot;}]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (new Map())
                ->center(new Point(48.8566, 2.3522))
                ->zoom(12)
                ->addPolyline(new Polyline(points: [new Point(48.8566, 2.3522), new Point(48.8566, 2.3522), new Point(48.8566, 2.3522)], id: 'polyline1'))
                ->addPolyline(new Polyline(points: [new Point(1.1, 2.2), new Point(3.3, 4.4), new Point(5.5, 6.6)], infoWindow: new InfoWindow(content: 'Polyline'), id: 'polyline2')),
        ];
    }
}
