<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookController extends Controller {

    //
    private $repository;

    public function __construct(BookRepositoryInterface $repository) {
        $this->repository = $repository;

        $this->middleware('can:book list', ['only' => ['index', 'show']]);
        $this->middleware('can:book create', ['only' => ['create', 'store']]);
        $this->middleware('can:book edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:book delete', ['only' => ['destroy']]);
        $this->middleware('can:book restore', ['only' => ['restore']]);
    }

    public function index() {
        return Inertia::render('Books/booksIndex', [
                'can' => $this->_getRoles()
        ]);
    }

    public function getBooks(Request $request) {
        // Beállítások
        $config = $request->get('config', []);
        //$config = ['per_page' => 10];
        // Szűrők és keresések
        $filters = $request->get('filters', []);
        
        //$filters = [
        //    'search' => 're',
        //    'column' => 'title',
        //    'direction' => 'desc',
        //];
        // Szűrés kezelése
        if (count($filters) > 0) {
            // Ha van keresési paraméter, akkor...
            if (isset($filters['search'])) {
                // A keresési paramétert átteszem egy változóba
                $value = $filters['search'];

                // Keresési paraméter érvégyesítése az 'author' és 'title' mezőkre
                $this->repository->where('author', 'LIKE', "%$value%");
                $this->repository->orWhere('title', 'LIKE', "%$value%");
//                $this->repository->findWhere([
//                    ['author', 'LIKE', "%$value%"],
//                    ['title', 'LIKE', "%$value%"]
//                ]);
            }

            // ----------------
            // RENDEZÉS
            // ----------------
            // Rendezés a 'name' oszlop szerint
            $column = 'id';
            // Ha van más beállítás, akkor...
            if (isset($filters['column'])) {
                // azt állítom be
                $column = $filters['column'];
            }

            // Alap rendezési irány
            $direction = 'asc';
            // Ha van más beállítás, akkor...
            if (isset($filters['direction'])) {
                // azt állítom be
                $direction = $filters['direction'];
            }
            // Rendezés érvényesítése
            //$this->repository->orderBy($column, $direction);
        }

        // Oldaltörés értékének kezelése
        $per_page = count($config) != 0 && isset($config['per_page']) ? $config['per_page'] : config('app.per_page');

        // Adatok lekérése
        $books = $this->repository->paginate($per_page);
        
        // Adatcsomag összeállítása
        $data = [
            'books' => $books,
            'config' => $config,
            'filters' => $filters,
        ];
        
        // Adatcsomag visszaküldése
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(Request $request) {
        $book = new Book();
        
        return Inertia::render('Books/BooksCreate', [
            'can' => $this->_getRoles(),
            'book' => $book,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request) {
        // 
        $book = $this->repository->create($request->all());

        return redirect()->back()->with('message', __('books_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show() {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book) {
        return Inertia::render('Book/BookEdit', [
            'can' => $this->_getRoles(),
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, int $id) {
        $book = $this->repository->update($request->all(), $id);

        return response()->json($book, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) {
        $this->repository->delete($id);
        return redirect()->back()->with('message', __('books_deleted'));
    }

    public function restore(int $id) {
        $book = Book::onlyTrashed()->find($id);
        $res = $book->restore();

        return redirect()->back()->with('message', __('books_restored'));
    }
    
    private function _getRoles() {
        return [
               'list' => Auth::user()->can('book list'),
             'create' => Auth::user()->can('book create'),
               'edit' => Auth::user()->can('book edit'),
             'delete' => Auth::user()->can('book delete'),
            'restore' => Auth::user()->can('book restore'),
        ];
    }
}
