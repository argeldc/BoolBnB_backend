<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ApartmentRequest;
use App\Functions\Helper;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::id())->get();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = 'Inserisci appartamento';
        $method = 'POST';
        $route = route('admin.apartments.store');
        $button = 'Crea';
        $services = Service::all();
        $apartment = null;
        return view('admin.apartments.create-edit', compact('title', 'method', 'route', 'button', 'services', 'apartment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApartmentRequest $request)
    {
        $form_data = $request->all();

        $form_data['slug'] = Helper::generateSlug($form_data['title'], Apartment::class);
        $form_data['lon'] = 50.14444;
        $form_data['lat'] = -40.55555;
        $form_data['user_id'] = Auth::id();
        $form_data['address'] = $form_data['road'] . ',' . $form_data['city'];

        $data = request()->validate([
            'img' => 'required|file|mimes:jpeg,jpg,png,webp'
        ]);

        if (array_key_exists('img', $form_data)) {
            $form_data['img_name'] = $request->file('img')->getClientOriginalName();
            $form_data['img'] = Storage::put('uploads', $form_data['img']);
        }

        // dd($form_data);
        $new_apartment = Apartment::create($form_data);
        if (array_key_exists('services', $form_data)) {
            $new_apartment->services()->attach($form_data['services']);
        }

        return redirect()->route('admin.apartments.show', $new_apartment);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', Auth::id())->first();
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
