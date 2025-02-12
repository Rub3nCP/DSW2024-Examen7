<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('themes.index', compact('themes'));
    }

    public function create()
    {
        return view('themes.create');
    }

    public function store(Request $request)
    {
        Theme::create($request->all());
        return redirect()->route('themes.index');
    }
}