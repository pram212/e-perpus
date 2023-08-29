<?php

namespace App\Http\Controllers;

use App\Models\Master\Catalog;
use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use Inertia\Inertia;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogs = Catalog::when(request('search'), fn ($kategori) => 
                $kategori->where('name', 'like', '%'  .  request('search') . '%')
            )
            ->paginate(10)
            ->withQueryString();

        $requests = request()->all();

        return Inertia::render('Catalog/IndexCatalog', compact('catalogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Catalog/FormCatalog');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCatalogRequest $request)
    {
        $catalog = Catalog::create([
            'name' => $request->name
        ]);

        $notification = [
            'type' => 'success',
            'message' => $catalog->name . ' berhasil ditambahkan'
        ];

        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalog $catalog)
    {
        return Inertia::render('Catalog/FormCatalog' , compact('catalog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCatalogRequest $request, Catalog $catalog)
    {
        $catalog->update([
            'name' => $request->name
        ]);
        
        $notification = [
            'type' => 'success',
            'message' => $catalog->name . ' berhasil diubah'
        ];

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalog $catalog)
    {
        $notification = [
            'type' => 'success',
            'message' => $catalog->name . ' berhasil dihapus'
        ];

        if ($catalog->books()->count() > 0) {

            $notification = [
                'type' => 'error',
                'message' => 'gagal! ' . $catalog->name . ' telah terhubung dengan buku tertentu'
            ];

            return back()->with($notification);

        }

        $catalog->delete();

        return back()->with($notification);

    }
}
