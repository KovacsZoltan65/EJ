<?php

namespace Database\Seeders;

use App\Models\Log;
use Illuminate\Database\Seeder;

class LogsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('logs')->truncate();
        
        $arr_logs = [
            ['id' => 1,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 2,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 3,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 4,'user_id' => 1,'subdomain_id' => 1,'level' => 1,'what' => 'Felhasználó létrehozása','with' => 'a:3:{s:4:"name";s:15:"Kovács Zoltán";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:4:"role";s:1:"1";}',],
            ['id' => 5,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 6,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Jelszó módosítás','with' => 'nincs adat',],
            ['id' => 7,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 8,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 9,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 10,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 11,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 12,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 13,'user_id' => 1,'subdomain_id' => 1,'level' => 1,'what' => 'Példány adatainak szerkesztése','with' => 'a:12:{s:11:"subdomainId";s:1:"1";s:4:"name";s:39:"Showtime - Ejelenlet Developer Instance";s:9:"subdomain";s:8:"showtime";s:7:"db_name";s:12:"ej2_showtime";s:7:"db_host";s:9:"localhost";s:7:"db_port";s:4:"3306";s:7:"db_user";s:12:"ej2_showtime";s:11:"db_p',],
            ['id' => 14,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu','created_at' => '2023-06-19 08:53:23','updated_at' => '2023-06-19 08:53:23',],
            ['id' => 15,'user_id' => 1,'subdomain_id' => 1,'level' => 1,'what' => 'Példány adatainak szerkesztése','with' => 'a:12:{s:11:"subdomainId";s:1:"1";s:4:"name";s:39:"Showtime - Ejelenlet Developer Instance";s:9:"subdomain";s:8:"showtime";s:7:"db_name";s:12:"ej2_showtime";s:7:"db_host";s:9:"localhost";s:7:"db_port";s:4:"3306";s:7:"db_user";s:12:"ej2_showtime";s:11:"db_p',],
            ['id' => 16,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 17,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 18,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 19,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 20,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 21,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 22,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 23,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 24,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 25,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 26,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 27,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 28,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 29,'user_id' => 4,'subdomain_id' => 1,'level' => 1,'what' => 'Példány adatainak szerkesztése','with' => 'a:12:{s:11:"subdomainId";s:1:"1";s:4:"name";s:39:"Showtime - Ejelenlet Developer Instance";s:9:"subdomain";s:8:"showtime";s:7:"db_name";s:12:"ej2_showtime";s:7:"db_host";s:9:"localhost";s:7:"db_port";s:4:"3306";s:7:"db_user";s:12:"ej2_showtime";s:11:"db_p',],
            ['id' => 30,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 31,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 32,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 33,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 34,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 35,'user_id' => 1,'subdomain_id' => 4,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 36,'user_id' => 1,'subdomain_id' => 4,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 37,'user_id' => 1,'subdomain_id' => 4,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 38,'user_id' => 4,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'kovacs.zoltan@softc.hu',],
            ['id' => 39,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 40,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 41,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 42,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 43,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 44,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 45,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 46,'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 47,'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:670;s:22:"core_legal_entities_id";i:731;}',],
            ['id' => 48,'user_id' => 1,'subdomain_id' => 4,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:268;s:22:"core_legal_entities_id";i:268;}',],
            ['id' => 49,'user_id' => 1,'subdomain_id' => 5,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:269;s:22:"core_legal_entities_id";i:269;}',],
            ['id' => 50,'user_id' => 1,'subdomain_id' => 1,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:73;s:22:"core_legal_entities_id";i:73;}',],
            ['id' => 51,'user_id' => 1,'subdomain_id' => 2,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:994;s:22:"core_legal_entities_id";i:1027;}',],
            ['id' => 52,'user_id' => 1,'subdomain_id' => 2,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:995;s:22:"core_legal_entities_id";i:1028;}',],
            ['id' => 53,'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'Virtuális admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:15:"Kovács Zoltán";s:8:"language";s:1:"1";s:5:"email";s:22:"kovacs.zoltan@softc.hu";s:14:"core_person_id";i:671;s:22:"core_legal_entities_id";i:732;}',],
            ['id' => 54, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 55, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 56, 'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'Cég létrehozása','with' => 'Cég 2',],
            ['id' => 57, 'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'Külsős admin létrehozása','with' => 'a:6:{s:6:"firmId";s:1:"1";s:4:"name";s:10:"Nagy Béla";s:8:"language";s:1:"1";s:5:"email";s:16:"nagy.bela@ceg.hu";s:14:"core_person_id";i:672;s:22:"core_legal_entities_id";i:733;}',],
            ['id' => 58, 'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'Külsős admin létrehozása','with' => 'a:3:{s:6:"firmId";s:1:"2";s:14:"core_person_id";s:3:"672";s:22:"core_legal_entities_id";i:734;}',],
            ['id' => 59, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 60, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 61, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 62, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 63, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 64, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 65, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 66, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 67, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 68, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 69, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 70, 'user_id' => 1,'subdomain_id' => 5,'level' => 1,'what' => 'Példány adatainak szerkesztése','with' => 'a:12:{s:11:"subdomainId";s:1:"5";s:4:"name";s:6:"mars_p";s:9:"subdomain";s:4:"mars";s:7:"db_name";s:8:"ej2_mars";s:7:"db_host";s:9:"localhost";s:7:"db_port";s:4:"3306";s:7:"db_user";s:8:"ej2_mars";s:11:"db_password";s:16:"kxIrLsI9Z9ly3Qbx";s:5:"state";s:1',],
            ['id' => 71, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 72, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 73, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 74, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 75, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 76, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 77, 'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'Példány adatainak szerkesztése','with' => 'a:12:{s:11:"subdomainId";s:1:"3";s:4:"name";s:17:"Down Alapítvány";s:9:"subdomain";s:2:"da";s:7:"db_name";s:8:"ej2_da_p";s:7:"db_host";s:9:"localhost";s:7:"db_port";s:4:"3306";s:7:"db_user";s:8:"ej2_da_p";s:11:"db_password";s:15:"VQTTCmNHUB2uiKV";s:5:"sta',],
            ['id' => 78, 'user_id' => 1,'subdomain_id' => 3,'level' => 1,'what' => 'SSO kliens létrehozása','with' => 'client_name: SSO Down',],
            ['id' => 79, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 80, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 81, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 82, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 83, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 84, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 85, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
            ['id' => 86, 'user_id' => 1,'subdomain_id' => 0,'level' => 1,'what' => 'Belépés a központba','with' => 'ejadmin@softc.hu',],
        ]; 
        $count = count($arr_logs);
        
        $this->command->warn(PHP_EOL . 'Creating Logs...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_logs as $log)
        {
            Log::factory()->create($log);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Logs created');
    }
}