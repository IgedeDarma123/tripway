<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PilihanPaket extends Component
{
    public $packages;
    public $addons;

    public function __construct($packages = [], $addons = [])
    {
        $this->packages = $packages;
        $this->addons = $addons;
    }

    public function render()
    {
        return view('components.pilihan-paket');
    }
}

