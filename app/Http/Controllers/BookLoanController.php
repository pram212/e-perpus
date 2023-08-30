<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookLoanRequest;
use App\Http\Requests\UpdateBookLoanRequest;
use App\Models\Master\Book;
use App\Models\Transaction\BookLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class BookLoanController extends Controller
{
    public function index() 
    {   
        return Inertia::render('BookLoan/IndexBookLoan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('BookLoan/FormBookLoan');
    }

    public function store(StoreBookLoanRequest $request)
    {
        try {
            DB::beginTransaction();

            $books = collect($request->book_id)->map(fn ($book) => [ 'book_id' => $book['value'] ] );
    
            $bookLoan = BookLoan::create([
                'code' => time(),
                'user_id' => $request->user_id[0]['value'],
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
    
            $bookLoan->bookLoanDetail()->createMany($books);

            DB::commit();
    
            $notification = [
                'type' => 'success',
                'message' => 'peminjaman berhasil ditambahkan'
            ];

        } catch (\Exception $th) {
            DB::rollBack();

            $notification = [
                'type' => 'error',
                'message' => $th->getMessage()
            ];

            return back()->with($notification);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Inertia::render('BookLoan/FormBookLoan', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bookLoan = BookLoan::find($id)->load(['bookLoanDetail.book', 'user']);

        // return $bookLoan;

        return Inertia::render('BookLoan/FormBookLoan', compact('bookLoan'));
    }

    public function update(UpdateBookLoanRequest $request, $id)
    {
        $bookLoan= BookLoan::find($id);

        try {
            DB::beginTransaction();
    
            $bookLoan->update([
                'user_id' => $request->user_id[0]['value'],
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
    
            $bookLoan->bookLoanDetail()->delete();

            $books = collect($request->book_id)->map(fn ($book) => [ 'book_id' => $book['value'] ] );

            $bookLoan->bookLoanDetail()->createMany($books);

            DB::commit();
    
            $notification = [
                'type' => 'success',
                'message' => 'peminjaman berhasil diubah'
            ];

        } catch (\Exception $th) {
            DB::rollBack();

            $notification = [
                'type' => 'error',
                'message' => $th->getMessage()
            ];

            return back()->with($notification);
        }

    }

    public function getBookLoans()
    {
        $bookLoans = BookLoan::where('refund', false)
            ->when(
            request('search'),
            fn ($loan) =>
            $loan
                ->where('code', 'like', '%'  .  request('search') . '%')
                // ->orWhereHas('catalog', fn (Builder $query) => $query->where('name', 'like', '%'  .  request('search') . '%'))
            )
            ->with(['bookLoanDetail', 'user'])
            ->withCount('bookLoanDetail')
            ->paginate(25)
            ->withQueryString();

        return response()->json($bookLoans);
    }

    public function getBookOpitons() 
    {
        $books = Book::where('stock', '>', 0)
            ->when(
            request('query'),
            fn ($query) =>
                $query->where('title', 'like', '%'  .  request('query') . '%')
                    ->orWhere('isbn', 'like', '%'  .  request('query') . '%')
            )
            ->limit(50)
            ->get();

        return ['results' => $books];
    }

    public function getUserOpitons() 
    {
        $users = User::role('member')
            ->when( 
                request('query'),
                fn ($query) => $query->where('name', 'like', '%'  .  request('query') . '%')
            )
            ->with('profile')
            ->limit(50)
            ->get();

        return ['results' => $users];
    }

}
