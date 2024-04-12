<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    
    private $repository;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
        
        $this->middleware('can:user list',    ['only' => ['index', 'show']]);
        $this->middleware('can:user create',  ['only' => ['create', 'store']]);
        $this->middleware('can:user edit',    ['only' => ['edit', 'update']]);
        $this->middleware('can:user delete',  ['only' => ['destroy']]);
        $this->middleware('can:user restore', ['only' => ['restore']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(){
        
        $users = User::all();
        
        //\Log::info('users: ' . print_r($users, true));
        
        //foreach( $users as $user ){
        //    \Log::info('username: ' . print_r($user->name, true));
        //    $RoleName = $user->getRoleNames();
        //    \Log::info('RoleNames: ' . print_r($RoleName, true));
        //    $PermissionNames = $user->getPermissionNames();
        //    \Log::info('PermissionNames: ' . print_r($PermissionNames, true));
        //}
        
        return Inertia::render('Admin/User/UsersIndex', [
            'can' => $this->_getRoles(),
        ]);
    }

    public function getUsers(Request $request){
        // Beállítások
        $config = $request->get('config', []);
        //$config = ['per_page' => 10];
        
        // Szűrők és keresések
        $filters = $request->get('filters', []);
        
        //\Log::info('config: ' . print_r($config, true));
        //\Log::info('filters: ' . print_r($filters, true));
        
        if( count($filters) > 0 )
        {
            // Ha van keresési paraméter, akkor...
            if( isset($filters['search']) )
            {
                //\Log::info('filters');
                // A keresési paramétert átteszem egy változóba
                $value = $filters['search'];
                //\Log::info('value: ' . print_r($value, true));
                // Keresési paraméter érvégyesítése az 'author' és 'title' mezőkre
                $this->repository->where('name', 'LIKE', "%$value%");
                $this->repository->orWhere('email', 'LIKE', "%$value%");
                /*
                $this->repository->findWhere([
                    ['name', 'LIKE', "%$value%"],
                    ['email', 'LIKE', "%$value%"]
                ]);
                */
            }
            
            // ----------------
            // RENDEZÉS
            // ----------------
            
            // Rendezés a 'name' oszlop szerint
            $column = 'name';
            // Ha van más beállítás, akkor...
            if( isset($filters['column']) )
            {
                // azt állítom be
                $column = $filters['column'];
            }
            
            // Alap rendezési irány
            $direction = 'asc';
            // Ha van más beállítás, akkor...
            if( isset($filters['direction']) ){
                // azt állítom be
                $direction = $filters['direction'];
            }
            // Rendezés érvényesítése
            $this->repository->orderBy($column, $direction);
        }
        
        // Oldaltörés értékének kezelése
        $per_page = count($config) != 0 && isset($config['per_page']) 
            ? $config['per_page'] 
            : config('app.per_page');
        
        $users = $this->repository->paginate($per_page);
        //\Log::info('users: ' . print_r($users, true));
        
        foreach( $users as $user ) {            
            $roleNames = $user->getRoleNames();
            
            $permissionNames = $user->getPermissionNames();
            
            $user->roleNames = $roleNames;
            $user->permissionNames = $permissionNames;
        }
        
        // Adatcsomag összeállítása
        $data = [
              'users' => $users,
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
        return Inertia::render('Admin/User/UsersCreate', [
                    'can' => $this->_getRoles(),
                   'user' => new User(),
                  'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request){
        $user = $this->repository->create($request->all());
        
        return redirect()->back()->with('message', __('users_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id){}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user){
        $roles = Role::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
        //$roles = Role::all();
        //\Log::info('UserController@edit $roles: ' . print_r($roles, true));
        
        $permissions = Permission::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
        //$permissions = Permission::all();
        //\Log::info('UserController@edit $permissions: ' . print_r($permissions, true));
        
        $roleNames = $user->getRoleNames();
            
        $permissionNames = $user->getPermissionNames();

        $user->roleNames = $roleNames;
        $user->permissionNames = $permissionNames;
        //\Log::info('UserController@edit $user: ' . print_r($user, true));
        
        return Inertia::render('Admin/User/UsersEdit', [
                    'can' => $this->_getRoles(),
                   'user' => $user,
                  'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        dd($request, $id);
        //$user = $this->repository->update($request->all(), $id);
        
        //return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->repository->delete($id);
        
        return redirect()->back()->with('message', __('userss_deleted'));
    }
    
    public function restore(int $id)
    {
        $user = User::onlyTrashed()->find($id);
        
        $res = $user->restore();
        
        return redirect()->back()->with('message', __('users_restored'));
    }

    private function _getRoles(){
        return [
               'list' => Auth::user()->can('user list'),
             'create' => Auth::user()->can('user create'),
               'edit' => Auth::user()->can('user edit'),
             'delete' => Auth::user()->can('user delete'),
            'restore' => Auth::user()->can('user restore'),
        ];
    }
    
    public function changeRoles(Request $request) {
        //\Log::info('id: ' . print_r($id, true));
        \Log::info('request: ' . print_r($request, true));
    }
}
