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
use Symfony\UX\Map\Test\RendererTestCase;
use Symfony\UX\StimulusBundle\Helper\StimulusHelper;

class LeafletRendererTest extends RendererTestCase
{
    public function provideTestRenderMap(): iterable
    {
        $map = (new Map())
            ->center(new Point(48.8566, 2.3522))
            ->zoom(12);

        yield 'simple map' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => $map,
        ];

        yield 'with custom attributes' => [
            'expected_render' => '<div data-controller="my-custom-controller symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[]" class="map"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => $map,
            'attributes' => ['data-controller' => 'my-custom-controller', 'class' => 'map'],
        ];

        yield 'with markers and infoWindows' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[{&quot;position&quot;:{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},&quot;title&quot;:&quot;Paris&quot;,&quot;infoWindow&quot;:null,&quot;extra&quot;:[],&quot;@id&quot;:&quot;abd45a2c703af97a&quot;},{&quot;position&quot;:{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},&quot;title&quot;:&quot;Lyon&quot;,&quot;infoWindow&quot;:{&quot;headerContent&quot;:null,&quot;content&quot;:&quot;Lyon&quot;,&quot;position&quot;:null,&quot;opened&quot;:false,&quot;autoClose&quot;:true,&quot;extra&quot;:[]},&quot;extra&quot;:[],&quot;@id&quot;:&quot;219637cbd8e62ea6&quot;}]" data-symfony--ux-leaflet-map--map-polygons-value="[]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (clone $map)
                ->addMarker(new Marker(new Point(48.8566, 2.3522), 'Paris'))
                ->addMarker(new Marker(new Point(48.8566, 2.3522), 'Lyon', infoWindow: new InfoWindow(content: 'Lyon'))),
        ];

        yield 'with polygons and infoWindows' => [
            'expected_render' => '<div data-controller="symfony--ux-leaflet-map--map" data-symfony--ux-leaflet-map--map-provider-options-value="{}" data-symfony--ux-leaflet-map--map-center-value="{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}" data-symfony--ux-leaflet-map--map-zoom-value="12" data-symfony--ux-leaflet-map--map-fit-bounds-to-markers-value="false" data-symfony--ux-leaflet-map--map-options-value="{&quot;tileLayer&quot;:{&quot;url&quot;:&quot;https:\/\/tile.openstreetmap.org\/{z}\/{x}\/{y}.png&quot;,&quot;attribution&quot;:&quot;\u00a9 &lt;a href=\&quot;https:\/\/www.openstreetmap.org\/copyright\&quot;&gt;OpenStreetMap&lt;\/a&gt;&quot;,&quot;options&quot;:[]},&quot;@provider&quot;:&quot;leaflet&quot;}" data-symfony--ux-leaflet-map--map-markers-value="[]" data-symfony--ux-leaflet-map--map-polygons-value="[{&quot;points&quot;:[{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522},{&quot;lat&quot;:48.8566,&quot;lng&quot;:2.3522}],&quot;title&quot;:null,&quot;infoWindow&quot;:null,&quot;extra&quot;:[],&quot;@id&quot;:&quot;2dc7aa290e8fc88a&quot;},{&quot;points&quot;:[{&quot;lat&quot;:1.1,&quot;lng&quot;:2.2},{&quot;lat&quot;:3.3,&quot;lng&quot;:4.4},{&quot;lat&quot;:5.5,&quot;lng&quot;:6.6}],&quot;title&quot;:null,&quot;infoWindow&quot;:{&quot;headerContent&quot;:null,&quot;content&quot;:&quot;Polygon&quot;,&quot;position&quot;:null,&quot;opened&quot;:false,&quot;autoClose&quot;:true,&quot;extra&quot;:[]},&quot;extra&quot;:[],&quot;@id&quot;:&quot;d6cab193e60e5faf&quot;}]"></div>',
            'renderer' => new LeafletRenderer(new StimulusHelper(null)),
            'map' => (clone $map)
                ->addPolygon(new Polygon(points: [new Point(48.8566, 2.3522), new Point(48.8566, 2.3522), new Point(48.8566, 2.3522)]))
                ->addPolygon(new Polygon(points: [new Point(1.1, 2.2), new Point(3.3, 4.4), new Point(5.5, 6.6)], infoWindow: new InfoWindow(content: 'Polygon'))),
        ];
    }
}
