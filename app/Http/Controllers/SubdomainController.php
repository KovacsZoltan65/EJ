<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubdomainRequest;
use App\Http\Requests\UpdateSubdomainRequest;
use App\Interfaces\SubdomainRepositoryInterface;
use App\Models\Subdomain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SubdomainController extends Controller {

    private $repository;

    public function __construct(SubdomainRepositoryInterface $repository) {
        $this->repository = $repository;

        $this->middleware('can:subdomain list', ['only' => ['index', 'show']]);
        $this->middleware('can:subdomain create', ['only' => ['create', 'store']]);
        $this->middleware('can:subdomain edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:subdomain destroy', ['only' => ['destroy']]);
        $this->middleware('can:subdomain restore', ['only' => ['restore']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Inertia::render('Subdomains/SubdomainsIndex', [
                'can' => $this->_getRoles(),
        ]);
    }

    public function getSubdomains(Request $request) {
        // Beállítások
        $config = $request->get('config', []);
        //$config = ['per_page' => 10];
        // Szűrők és keresések
        $filters = $request->get('filters', []);

        // Szűrés kezelése
        if (count($filters) > 0) {
            // Ha van keresési paraméter, akkor...
            if (isset($filters['search'])) {
                // A keresési paramétert átteszem egy változóba
                $value = $filters['search'];
                // Keresési paraméter érvégyesítése az 'author' és 'title' mezőkre
                /*
                $this->repository->findWhere([
                    ['subdomain', 'LIKE', "%$value%"],
                    ['url', 'LIKE', "%$value%"],
                    ['name', 'LIKE', "%$value%"],
                    ['db_host', 'LIKE', "%$value%"],
                    ['db_name', 'LIKE', "%$value%"],
                    ['db_user', 'LIKE', "%$value%"],
                ]);
                */
                $this->repository->where('subdomain', 'LIKE', "%$value%");
                $this->repository->orWhere('url', 'LIKE', "%$value%");
                $this->repository->orWhere('name', 'LIKE', "%$value%");
                $this->repository->orWhere('db_host', 'LIKE', "%$value%");
                $this->repository->orWhere('db_name', 'LIKE', "%$value%");
                $this->repository->orWhere('db_user', 'LIKE', "%$value%");
            }

            // ----------------
            // RENDEZÉS
            // ----------------
            // Rendezés a 'name' oszlop szerint
            $column = 'name';
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
            $this->repository->orderBy($column, $direction);
        }

        // Oldaltörés értékének kezelése
        $per_page = count($config) != 0 && isset($config['per_page']) ? $config['per_page'] : config('app.per_page');

        // Adatok lekérése
        $subdomains = $this->repository->paginate($per_page);

        // Adatcsomag összeállítása
        $data = [
            'subdomains' => $subdomains,
            'config' => $config,
            'filters' => $filters,
        ];

        // Adatcsomag visszaküldése
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        $subdomain = new Subdomain();
        return Inertia::render('Subdomains/SubdomainsCreate', [
                'subdomain' => $subdomain,
                'can' => $this->_getRoles(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    //public function store_01(Request $request) {
    //    dd($request->all());
    //}

    public function store(StoreSubdomainRequest $request) {
        //dd($request);
        $subdomain = $this->repository->create($request->all());

        return redirect()->back()->with('message', __('subdomain_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show() {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subdomain $subdomain) {
        return Inertia::render('Subdomains/SubdomainsEdit', [
                'subdomain' => $subdomain,
                'can' => $this->_getRoles(),
                ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubdomainRequest $request, $id) {
        $this->repository->update($request->all(), $id);

        return redirect()->back()->with('message', __('subdomains_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) {
        $this->repository->delete($id);
        return redirect()->back()->with('message', __('subdomain_deleted'));
    }

    public function restore(int $id) {
        $subdomain = Subdomain::onlyTrashed()->find($id);
        $res = $subdomain->restore();

        return redirect()->back()->with('message', __('subdomain_restored'));
    }

    private function _getRoles() {
        //
        return [
            'list' => Auth::user()->can('subdomain list'),
            'create' => Auth::user()->can('subdomain create'),
            'edit' => Auth::user()->can('subdomain edit'),
            'delete' => Auth::user()->can('subdomain delete'),
            'restore' => Auth::user()->can('subdomain restore'),
        ];
    }
}
