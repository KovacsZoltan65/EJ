<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Subdomain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoleController extends Controller {

    private $repository;

    public function __construct(RoleRepositoryInterface $repository) {
        $this->repository = $repository;

        $this->middleware('can:role list', ['only' => ['index', 'show']]);
        $this->middleware('can:role create', ['only' => ['create', 'store']]);
        $this->middleware('can:role edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:role delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Inertia::render('Admin/Role/RolesIndex', [
            'can' => $this->_getRoles(),
        ]);
    }

    public function getRoles(Request $request) {
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
        $roles = $this->repository->paginate($per_page);
        $subdomains = Subdomain::all();

        // Adatcsomag összeállítása
        $data = [
                 'roles' => $roles,
            'subdomains' => $subdomains,
                'config' => $config,
               'filters' => $filters,
        ];

        // Adatcsomag visszaküldése
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resourOce.
     */
    public function create(Request $request) {
        $role = new Role();
        $permissions = Permission::all()->toArray();
        $roles = Role::all()->toArray();
        
        return Inertia::render('Admin/Role/RolesCreate', [
                    'can' => $this->_getRoles(),
                   'role' => $role,
                  'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request) {
        $role = $this->repository->create($request->all());

        return redirect()->back()->with('message', __('roles_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role) {
        $permissions = Permission::all()->toArray();
        $roles = Role::all()->toArray();
        
        return Inertia::render('Admin/Role/RolesEdit', [
                    'can' => $this->_getRoles(),
                   'role' => $role,
                  'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, int $id) {
        $role = $this->repository->update($request->all(), $id);

        return response()->json($role, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) {
        $this->repository->delete($id);

        return redirect()->back()->with('message', __('role_deleted'));
    }

    /**
     * Visszaállítás
     */
    public function restore(int $id) {
        $role = Role::onlyTrashed()->find($id);
        $res = $role->restore();

        return redirect()->back()->with('message', __('roles_restored'));
    }
    
    private function _getRoles(){
        return [
               'list' => Auth::user()->can('role list'),
             'create' => Auth::user()->can('role create'),
               'edit' => Auth::user()->can('role edit'),
             'delete' => Auth::user()->can('role delete'),
            'restore' => Auth::user()->can('role restore'),
        ];
    }
}
