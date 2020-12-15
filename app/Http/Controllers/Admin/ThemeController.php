<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * @param $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->input('app_theme') === '1') {
            $themeFileSource = base_path('resources/sass/themes/normal/_appTheme.scss');
        }
        if ($request->input('app_theme') === '2') {
            $themeFileSource = base_path('resources/sass/themes/light/_appTheme.scss');
        }
        if ($request->input('app_theme') === '3') {
            $themeFileSource = base_path('resources/sass/themes/dark/_appTheme.scss');
        }

        $themeFileDestination = base_path('resources/sass/_appTheme.scss');
        copy($themeFileSource, $themeFileDestination);
        sleep(8);
        return redirect()->back();
    }
}
