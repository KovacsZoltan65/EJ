<?php

namespace App\Http\Controllers;

class LanguageController extends Controller {

    public function index() {
        $locale = request()->get('locale');
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
