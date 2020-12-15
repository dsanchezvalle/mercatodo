<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BookFilter extends Component
{
    /**
     * @var
     */
    public $route;

    /**
     * Create a new component instance.
     *
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.book-filter');
    }
}
