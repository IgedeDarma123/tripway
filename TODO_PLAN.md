# Google Maps for Destinations Plan

## Information Gathered

- tours/show.blade.php has itinerary section
- Destination model/migration no lat/lng fields
- Static embed iframe for each destination location in Bali (Ubud, Seminyak, etc.)
- Add after itinerary, before inclusions

## Plan

1. Add new info-section after itinerary in tours/show.blade.php
2. Dynamic iframe based on $tour->destination->name using Google Maps embed
3. Style map iframe with radius/shadow
4. Add to @section('styles') .tour-map-iframe

## Dependent Files

- tripway/resources/views/tours/show.blade.php

## Followup

- `php artisan view:clear`
- Test tours/show/{slug}

Confirm plan before editing?
