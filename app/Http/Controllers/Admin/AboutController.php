<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutRequest;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::with('aboutLists')->first();

        return view('dashboard.about.main.index', compact('about'));
    }

    public function create()
    {
        return view('dashboard.about.main.create');
    }

    public function store(StoreAboutRequest $request)
    {
        dd($request->validated());
    }

}
