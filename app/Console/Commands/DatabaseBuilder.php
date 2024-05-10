<?php

/*
 * $signature = 'db:builder {subdomain}'; 
 * 
 * php artisan db:builder
 * php artisan db:builder showtime
 * php artisan db:builder --db_name "ej2_showtime_p" --db_user "ej2_showtime_p" --db_password "m2a2cSrqIk4Pm9oD" --import_path "\backup" --export_path "\backup" --import_file_name "import.sql"
 * php artisan db:builder -N "ej2_showtime_p" -U "ej2_showtime_p" -P "m2a2cSrqIk4Pm9oD" -I "\backup" -E "\backup" -F "import.sql"
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Contracts\Console\PromptsForMissingInput;

class DatabaseBuilder extends Command //implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:builder {subdomain?} : subdomain neve (HQ)'
            . ' {--N|db_name= : adatbázis neve}'
            . ' {--U|db_user= : felhasználó neve}'
            . ' {--P|db_password= : jelszó} '
            . ' {--I|import_path= : import fájl helye}'
            . ' {--E|export_path= : export fájl helye}' 
            . ' {--F|import_file_name= : dump fájl neve}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Példány datbázisának elkészítése';

    protected bool $valid = false, 
            $import_valid = false,
            $export_valid = false;
    
    protected string $storage_path = '/db',
            $subdomain = '', 
            $db_name = '',
            $db_user = '',
            $db_password = '',
            $export_path = '',
            $import_path = '',
            $import_file_name = '',
            $export_file_name = '';
    
    
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //dd($this->arguments(),$this->options());
        /*
        dd(
            $this->option('db_name'),
            $this->option('db_user'),
            $this->option('db_password'),
        );
        */
        
        // Inicializálás
        $this->init();
        
        $processes = [
            'mysqlExport','migration','seeding','mysqlImport'
        ];

        $aa = $this->withProgressBar($processes, function($process){
            $this->$process();
        });
        $this->line($aa);
        
    }
    
    // Könyvtárak ellenőrzése
    private function checkFolders():void
    {
        // Export könyvtár ellenőrzése
        $this->checkExportFolder();
        // Import könyvtár ellenőrzése
        $this->checkImportFolder();
    }
    
    // Export könyvtár ellenőrzése
    private function checkExportFolder()
    {
        if( $this->export_path !== '' ) {
            // Export könyvtár elérési útjának összeállítása
            // és ellenőrzése. Ha nincs, létrehozza.
            if( !strpos( $this->export_path, $this->storage_path ) ) {
                $this->export_path = $this->storage_path . $this->export_path . '/' . $this->db_name;
            }
            
            if( !\Storage::exists($this->export_path) ) {
                \Storage::makeDirectory($this->export_path, 0775, true); //creates directory
            }
        }
    }
    
    // Import könyvtár ellenőrzése
    private function checkImportFolder() {
        if( $this->import_path !== '' ) {
            // Export könyvtár elérési útjának összeállítása
            // és ellenőrzése. Ha nincs, létrehozza.
            if( !strpos( $this->import_path, $this->storage_path ) ) {
                $this->import_path = $this->storage_path . $this->import_path . '/' . $this->db_name;
            }
            
            if( !\Storage::exists($this->import_path) ) {
                \Storage::makeDirectory($this->import_path, 0775, true); //creates directory
            }
        }
    }
    
    // Fájlok ellenőrzése
    private function checkFiles()
    {
        $this->checkImportFile();
        
        $this->checkExportFile();
    }
    
    private function checkImportFile():void
    {
        $this->import_valid = false;
        
        // Ha van filename, akkor le is kell ellenőrizni
        if( $this->import_path !== '' && $this->import_file_name !== '' ) {
            if(\Storage::exists($this->import_path . '\\' . $this->import_file_name)) {
                $this->import_valid = true;
            }
        }
    }
    
    private function checkExportFile():void
    {
        $this->export_valid = false;
        
        if( $this->export_path !== '' && $this->export_file_name !== '' ) {
            if( !\Storage::exists($this->export_path . '\\' . $this->export_file_name) ) {
                $this->export_valid = true;
            }
        }
        
        var_dump($this->export_valid);
    }

    private function migration():void
    {
        sleep(2);
    }
    
    private function seeding():void
    {
        sleep(2);
    }
    
    private function mysqlImport():void
    {
        if( $this->import_valid ) {
            $exec = 'mysql -u ' . $this->db_user . ' -p'. $this->db_password . ' ' . $this->db_name . ' < ' . $this->import_path . '/' . $this->import_file_name;
            try{
                exec($exec, $output);
            } catch(\Exception $e) {
                $this->line($e);
            }
        }
    }

    private function mysqlExport():void
    {
        $path = storage_path('app/' . $this->export_path . '/' . $this->export_file_name);
        $this->line('path: ' . $path );
        
        if( $this->export_valid ) {
            $exec = 'mysqldump -u ' . $this->db_user . ' -p'. $this->db_password . ' ' . $this->db_name . ' > ' . $path . ' --no-tablespaces';
            
            $this->line('exec: ' . $exec );
            
            try {
                exec($exec, $output);
            } catch( \Exception $e ) {
                $this->line($e);
            }
        }
    }   

    private function init(): void 
    {
        $this->valid = false;
        
        // Ha nincs subdomain név, akkor megpróbálom beszerezni
        if( $this->argument('subdomain') == null ) {
            // Ha paraméterként nem kaptam adatbázis nevet, bekérem a felhasználótól
            $this->db_name = $this->option('db_name') ?? $this->ask('db_name?', '');
            // Ha paraméterként nem kaptam felhasználó nevet nevet, bekérem a felhasználótól.
            // Alap beállítás az adatbázisnév lesz.
            $this->db_user = $this->option('db_user') ?? $this->ask('db_user?', $this->db_name);
            // Ha paraméterként nem kaptam jelszót, bekérem a felhasználótól
            $this->db_password = $this->option('db_password') ?? $this->ask('db_password?', '');
        } else {
            // A subdomain névvel dolgozunk tovább
            $this->subdomain = $this->argument('subdomain');
        }
        
        if($this->db_name !== '' || $this->subdomain !== '') {
            $this->valid = true;
        }
        
        // A mentési útvonal, opcionális
        $this->export_path = $this->option('export_path') ?? $this->ask('export_path?', '');
        
        // A feltöltendő fájl útvonala, opcionális
        $this->import_path = $this->option('import_path') ?? $this->ask('import_path?', '');
        
        //$this->file_name = $this->db_name . '_' . date('Y-m-d-H-i-s') . '.sql';
        $this->import_file_name = $this->option('import_file_name') ?? '';
        
        $this->export_file_name = $this->db_name . '_' . date('Y-m-d-H-i-s') . '.sql';

        // Szükséges könyvtárak ellenőrzése
        $this->checkFolders();
        
        // Szükséges fájlok ellenőrzése
        $this->checkFiles();
        
        // Változók kiírása
        $this->table(
            ['subdomain', 'db_name', 'db_user', 'db_password', 'export_path', 'import_path', 'import_file_name', 'export_file_name', 'valid', 'import_valid', 'export_valid'],
            [
                [
                    'subdomain' => $this->subdomain,
                    'db_name' => $this->db_name, 
                    'db_user' => $this->db_user, 
                    'db_password' => $this->db_password,
                    'export_path' => $this->export_path,
                    'import_path' => $this->import_path,
                    'import_file_name' => $this->import_file_name,
                    'export_file_name' => $this->export_file_name,
                    'valid' => $this->valid,
                    'import_valid' => $this->import_valid,
                    'export_valid' => $this->export_valid,
                ]
            ]
        );
    }
    
    /*
    |--------------------------------------------------------------------------
    | Zárolási azonosító
    |--------------------------------------------------------------------------
    |
    | Alapértelmezés szerint a Laravel a parancs nevét használja az alkalmazás 
    | gyorsítótárában lévő atomi zár beszerzéséhez használt karakterlánckulcs 
    | létrehozásához. Ezt a kulcsot azonban testreszabhatja úgy, hogy definiál 
    | egy metódust az Artisan parancsosztályban, lehetővé téve a parancs 
    | argumentumainak vagy beállításainak integrálását a kulcsba:isolatableId
    |
    */
    public function isolatableId()
    {
        // A parancs neve lesz az azonosító
        $id = $this->argument('command');
        
        if( $this->option('subdomain') !== null )
        {
            // Ha van subdomain paraméter, akkor az lesz az azonosító
            $id = $this->option('subdomain');
        }
        elseif( $this->option('db_name') !== null )
        {
            // Egyébként az adatbázisnév paraméter lesz az azonosító
            $id = $this->option('db_name');
        }
        
        return $id;
    }
    
    /*
    |--------------------------------------------------------------------------
    | Zárolás lejárati ideje
    |--------------------------------------------------------------------------
    |
    | Alapértelmezés szerint az elkülönítési zárolások a parancs befejezése 
    | után lejárnak. Vagy ha a parancs megszakad, és nem tud befejeződni, a 
    | zárolás egy óra múlva lejár. A zárolás lejárati idejét azonban 
    | beállíthatja egy metódus megadásával a parancsban:isolationLockExpiresAt
    |
    */
    public function isolationLockExpiresAt(): DateTimeInterface|DateInterval
    {
        return now()->addMinutes(5);
    }
    
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'subdomain' => 'Az aldomain neve?',
            'db_name' => 'Adatbázis neve?',
            'db_user' => 'Felhasználó neve?',
            'db_password' => 'Felhasználó jelszava?',
            'dump_file' => 'Feltöltendő fájl?',
            'save_path' => 'Mentés helye?'
        ];
    }
}
