<?php

namespace Database\Seeders;

use App\Models\VersionInformationEmailAddress;
use Illuminate\Database\Seeder;

class VersionInformationEmailAddressesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('version_information_email_addresses')->truncate();
        
        $arr_addresses = [
            ['id' => 1,  'name' => 'Ronkai György',                'email' => 'ejadmin_rgy@softc.hu',                    'subdomain' => '{"0":"showtime"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 2,  'name' => 'Szipli Viktória',              'email' => 'ejadmin_szv@softc.hu',                    'subdomain' => '{"0":"showtime"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 3,  'name' => 'Nándori Zsuzsa',               'email' => 'ejadmin_nzs@softc.hu',                    'subdomain' => '{"0":"showtime","1":"teszt"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
            ['id' => 4,  'name' => 'Tanka Veronika',               'email' => 'ejadmin_tv@softc.hu',                     'subdomain' => '{"0":"showtime","1":"teszt","2":"da","3":"lgtoray","4":"mars"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 5,'send_email' => 1,'active' => 1,],
            ['id' => 5,  'name' => 'Varga Viktor',                 'email' => 'ejadmin_vv@softc.hu',                     'subdomain' => '{"0":"showtime"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 6,  'name' => 'Zsák Tünde',                   'email' => 'ejadmin_zst@softc.hu',                    'subdomain' => '{"0":"showtime","1":"teszt","2":"da","3":"lgtoray","4":"mars"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 5,'send_email' => 1,'active' => 1,],
            ['id' => 7,  'name' => 'Rick Ágnes',                   'email' => 'ejadmin_ra@softc.hu',                     'subdomain' => '{"0":"showtime","1":"teszt","2":"da","3":"lgtoray","4":"mars"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 5,'send_email' => 1,'active' => 1,],
            ['id' => 8,  'name' => 'Kovács Zoltán',                'email' => 'kovacs.zoltan@softc.hu',                  'subdomain' => '{"0":"showtime","1":"teszt","2":"da","3":"lgtoray","4":"mars"}','external_admin' => 0,'internal_admin' => 0,'papik' => 1,'valid_counter' => 5,'send_email' => 1,'active' => 1,],
            ['id' => 9,  'name' => 'Szabadi Mónika',               'email' => 'monika.szabadi@inter.ikea.com',           'subdomain' => '{"0":"teszt"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 10, 'name' => 'Papp András',                  'email' => 'andras.papp@inter.ikea.com',              'subdomain' => '{"0":"teszt"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 11, 'name' => 'Horváth Szilvia',              'email' => 'szilvia.horvath@inter.ikea.com',          'subdomain' => '{"0":"teszt"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,], 
            ['id' => 12, 'name' => 'Márton Attila',                'email' => 'attila.marton@inter.ikea.com',            'subdomain' => '{"0":"teszt"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 13, 'name' => 'Varga Noémi',                  'email' => 'noemi.varga@inter.ikea.com',              'subdomain' => '{"0":"teszt"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 14, 'name' => 'Baczoniné Lukács Xénia',       'email' => 'xenia.baczonine.lukacs@inter.ikea.com',   'subdomain' => '{"0":"teszt"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 15, 'name' => 'Nándori Zsuzsa',               'email' => 'nandori.zsuzsa@softc.hu',                 'subdomain' => '{"0":"teszt"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 16, 'name' => 'Szabó Ákos',                   'email' => 'szaboakos@downalapitvany.hu',             'subdomain' => '{"0":"da"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 17, 'name' => 'Gerecze-Szalay Paula Mariann', 'email' => 'gereczepaula@downalapitvany.hu',          'subdomain' => '{"0":"da"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 18, 'name' => 'Dr. Gruiz Katalin',            'email' => 'gruiz@downalapitvany.hu',                 'subdomain' => '{"0":"da"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 19, 'name' => 'Szaszák Tibor',                'email' => 'tibor.szaszak@gmail.com',                 'subdomain' => '{"0":"da"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 20, 'name' => 'Dulcz Adrienn',                'email' => 'dulczadrien@gmail.com',                   'subdomain' => '{"0":"da"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 1,'send_email' => 1,'active' => 1,],
            ['id' => 21, 'name' => 'Nagy Béla',                    'email' => 'nagy.bela@ceg.hu',                        'subdomain' => '{"0":"da"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
            ['id' => 22, 'name' => 'Molnár Mónika',                'email' => 'monika.molnar.s3@mail.toray',             'subdomain' => '{"0":"lgtoray","1":"mars"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
            ['id' => 23, 'name' => 'Melecsky Réka',                'email' => 'reka.melecsky.v4@mail.toray',             'subdomain' => '{"0":"lgtoray","1":"mars"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
            ['id' => 24, 'name' => 'Kersánszki-Scheller Tímea',    'email' => 'timea.kersanszki-scheller.q7@mail.toray', 'subdomain' => '{"0":"lgtoray","1":"mars"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
            ['id' => 25, 'name' => 'Katona Krisztián',             'email' => 'krisztian.katona.f6@mail.toray',          'subdomain' => '{"0":"lgtoray","1":"mars"}','external_admin' => 0,'internal_admin' => 1,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
            ['id' => 26, 'name' => 'LG Toray Admin',               'email' => 'hr.thu.ug@mail.toray',                    'subdomain' => '{"0":"lgtoray","1":"mars"}','external_admin' => 1,'internal_admin' => 0,'papik' => 0,'valid_counter' => 2,'send_email' => 1,'active' => 1,],
        ];
        $count = count($arr_addresses);
        
        $this->command->warn(PHP_EOL . 'Creating Addresses...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_addresses as $address)
        {
            VersionInformationEmailAddress::factory()->create($address);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Addresses created');        
    }
}