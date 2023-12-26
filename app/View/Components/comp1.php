<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class comp1 extends Component
{
    /**
     * Create a new component instance.
     */
    public $componentPropertie;
    public function __construct($attr)
    {
        $this->componentPropertie = $attr;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comp1');
    }
}
