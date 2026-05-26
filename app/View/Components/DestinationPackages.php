<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class DestinationPackages extends Component
{
    public Collection $packages;
    public Collection $addons;
    public string $destinationId;
    public string $bookingRoute;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $packages = [],
        $addons = [],
        $destinationId = '',
        $bookingRoute = 'bookings.store'
    ) {
        $this->packages = collect($packages);
        $this->addons = collect($addons);
        $this->destinationId = $destinationId;
        $this->bookingRoute = $bookingRoute;
    }

    public function render()
    {
        return view('components.destination-packages');
    }
}

