<?php

/**
 * Description of BookControllerTest
 *
 * @author kovacs.zoltan
 */

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;



class BookControllerTest extends TestCase {

    //protected function setUp(): void{
    //    Log::info('setUp');
    //}
    
    //public static function setUpBeforeClass(): void {
    //    Log::info('setUpBeforeClass');
    //}
    
    public function test_getBooks() {
        
        // ------------
        // Paraméterek
        // ------------

        // Táblázat sor / oldal
        $per_page = Config::get('app.per_page');
        
        // Request osztály példányosítása
        $request = new Request();
        // Beállítások és szűrők
        $conf = [];
        
        // Könyvek controller példányosítása
        $bookController = new BookController();

        // ----------------------------------------------
        // Adatok lekérése az átadott paraméterek alapján
        // ----------------------------------------------

        // Csak az oldaltörést adom át.
        $conf = [
            'config' => [
                'per_page' => $per_page,
            ],
            'filter' => [],
        ];

        // A paramétertömb átadása a request osztálynak
        $request->merge($conf);

        // Adatok lekérése a paraméterek alapján.
        $res = $bookController->getBooks($request);

        // Adathalmaz lekérése asszociatív tömb alakban
        $books_data = $res->getData(true);

        // Könyv adathalmaz
        $books = $books_data['books'];
        
        // Rekordok száma
        $books_count = count($books['data']);

        // A rekordok számának meg kell egyeznie az átadott paraméterrel
        $this->assertEquals($per_page, $books_count, "Elvárt: {$per_page}; Kapott: {$books_count}");

    }
}
