<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $variant;
    
    public function __construct($type = 'button', $variant = 'primary')
    {
        $this->type = $type;
        $this->variant = $variant;
    }

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
