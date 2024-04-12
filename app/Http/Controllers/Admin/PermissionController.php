<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PermissionController extends Controller {

    private $repository;

    public function __construct(\App\Interfaces\PermissionRepositoryInterface $repository) {
        $this->repository = $repository;

        $this->middleware('can:permission list', ['only' => ['index', 'show']]);
        $this->middleware('can:permission create', ['only' => ['create', 'store']]);
        $this->middleware('can:permission edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:permission delete', ['only' => ['destroy']]);
        $this->middleware('can:permission restore', ['only' => ['restore']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Inertia::render('Admin/Permission/PermissionsIndex', [
                'can' => [
                    'list' => Auth::user()->can('permission list'),
                    'create' => Auth::user()->can('permission create'),
                    'edit' => Auth::user()->can('permission edit'),
                    'delete' => Auth::user()->can('permission delete'),
                    'restore' => Auth::user()->can('permission restore'),
                ]
        ]);
    }

    public function getPermissions(Request $request) {
        // Beállítások
        $config = $request->get('config', []);

        // Szűrők és keresések
        $filters = $request->get('filters', []);

        // Szűrés kezelése
        if (count($filters) > 0) {
            // Ha van keresési paraméter, akkor...
            if (isset($filters['search'])) {
                // A keresési paramétert átteszem egy változóba
                $value = $filters['search'];
                // Keresési paraméter érvégyesítése az 'author' és 'title' mezőkre
                $this->repository->where('name', 'LIKE', "%$value%");
                $this->repository->orWhere('guard_name', 'LIKE', "%$value%");
                /*
                $this->repository->findWhere([
                    ['author', 'LIKE', "%$value%"],
                    ['title', 'LIKE', "%$value%"]
                ]);
                */
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
        $permissions = $this->repository->paginate($per_page);

        // Adatcsomag összeállítása
        $data = [
            'permissions' => $permissions,
            'config' => $config,
            'filters' => $filters,
        ];

        // Adatcsomag visszaküldése
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resourOce.
     */
    public function create() {
        $permission = new Permission();
        
        return Inertia::render('Admin/Permission/PermissionsCreate', [
                   'can' => $this->_getRoles(),
            'permission' => $permission,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request) {
        $permission = $this->repository->create($request->all());

        return redirect()->back()->with('message', __('permissions_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission) {
        return Inertia::render('Admin/Permission/PermissionsEdit', [
                   'can' => $this->_getRoles(),
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, int $id) {
        $permission = $this->repository->update($request->all(), $id);

        return response()->json($permission, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) {
        $this->repository->delete($id);

        return redirect()->back()->with('message', __('permissions_deleted'));
    }

    public function response(int $id) {
        $permission = Permission::onlyTrashed()->find($id);

        $res = $permission->restore();

        return redirect()->back()->with('message', __('permissions_restored'));
    }
    
    private function _getRoles(){
        return [
               'list' => Auth::user()->can('permission list'),
             'create' => Auth::user()->can('permission create'),
               'edit' => Auth::user()->can('permission edit'),
             'delete' => Auth::user()->can('permission delete'),
            'restore' => Auth::user()->can('permission restore'),
        ];
    }
}
