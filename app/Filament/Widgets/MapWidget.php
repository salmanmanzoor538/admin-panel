<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

/**
 * Map Widget with multiple map types
 * Features: Google Maps, Leaflet.js, Vector Maps with markers and interactivity
 */
class MapWidget extends Widget
{
    protected static string $view = 'filament.widgets.map-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 7;
    
    public ?string $mapType = 'leaflet';
    
    protected function getViewData(): array
    {
        return [
            'mapType' => $this->mapType,
            'mapOptions' => $this->getMapOptions(),
            'markers' => $this->getMarkers(),
        ];
    }
    
    protected function getMapOptions(): array
    {
        return [
            'leaflet' => 'Leaflet (OpenStreetMap)',
            'google' => 'Google Maps',
            'vector' => 'Vector Map',
        ];
    }
    
    protected function getMarkers(): array
    {
        // Mock markers data - in a real application, this would come from a database
        return [
            [
                'id' => 1,
                'lat' => 40.7128,
                'lng' => -74.0060,
                'title' => 'New York City',
                'description' => 'The Big Apple',
                'icon' => 'fas fa-building',
                'color' => '#3b82f6',
            ],
            [
                'id' => 2,
                'lat' => 34.0522,
                'lng' => -118.2437,
                'title' => 'Los Angeles',
                'description' => 'City of Angels',
                'icon' => 'fas fa-sun',
                'color' => '#f59e0b',
            ],
            [
                'id' => 3,
                'lat' => 41.8781,
                'lng' => -87.6298,
                'title' => 'Chicago',
                'description' => 'Windy City',
                'icon' => 'fas fa-wind',
                'color' => '#10b981',
            ],
            [
                'id' => 4,
                'lat' => 29.7604,
                'lng' => -95.3698,
                'title' => 'Houston',
                'description' => 'Space City',
                'icon' => 'fas fa-rocket',
                'color' => '#ef4444',
            ],
            [
                'id' => 5,
                'lat' => 33.4484,
                'lng' => -112.0740,
                'title' => 'Phoenix',
                'description' => 'Valley of the Sun',
                'icon' => 'fas fa-mountain',
                'color' => '#8b5cf6',
            ],
        ];
    }
    
    public function getMapTypeOptions(): array
    {
        return $this->getMapOptions();
    }
}