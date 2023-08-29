<?php

namespace App\Http\Controllers;

use App\Models\Master\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Master\Catalog;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use function Laravel\Prompts\select;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Book/IndexBook');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Book/FormBook');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'book_id' => $request->book_id,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'published_at' => $request->published_at,
            'stock' => $request->stock,
            'catalog_id' => $request->catalog_id[0]['value'],
        ]);

        $notification = [
            'type' => 'success',
            'message' => $book->title . ' berhasil ditambahkan'
        ];

        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return Inertia::render('Book/FormBook', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $book->load('catalog');

        return Inertia::render('Book/FormBook', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'book_id' => $request->book_id,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'published_at' => $request->published_at,
            'stock' => $request->stock,
            'catalog_id' => $request->catalog_id[0]['value'],
        ]);

        $notification = [
            'type' => 'success',
            'message' => $book->title . ' berhasil diupdate'
        ];

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $notification = [
            'type' => 'success',
            'message' => $book->title . ' berhasil dihapus'
        ];

        // if ($book->books()->count() > 0) {

        //     $notification = [
        //         'type' => 'error',
        //         'message' => 'gagal! ' . $book->title . ' telah terhubung dengan buku tertentu'
        //     ];

        //     return back()->with($notification);

        // }

        $book->delete();

        return back()->with($notification);
    }

    public function getCatalog()
    {
        $catalogs = Catalog::when(
            request('query'),
            fn ($catalog) =>
            $catalog->where('name', 'like', '%'  .  request('query') . '%')
        )
            ->limit(50)
            ->get();

        return ['results' => $catalogs];
    }

    public function getBooks()
    {
        $books = Book::when(
            request('search'),
            fn ($book) =>
            $book
                ->where('title', 'like', '%'  .  request('search') . '%')
                ->orWhere('isbn', 'like', '%'  .  request('search') . '%')
                ->orWhere('author', 'like', '%'  .  request('search') . '%')
                ->orWhere('publisher', 'like', '%'  .  request('search') . '%')
                ->orWhere('published_at', 'like', '%'  .  request('search') . '%')
                ->orWhereHas('catalog', fn (Builder $query) => $query->where('name', 'like', '%'  .  request('search') . '%'))
            )
            ->with(['catalog:id,name'])
            ->paginate(25)
            ->withQueryString();

        return response()->json($books);
    }
}
