<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agencies')->insert([
            'name' => 'Piofx Media',
            'domain'=>'piofx.test',
            'settings' => '{"name":"Piofx Media Ltd","theme":"metronic4", "meta_title":"PIOFX","favicon_link":"https:\/\/i.imgur.com\/UaMeYDb.png","logo":"https:\/\/i.imgur.com\/MGEKhEi.png"}'
        ]);

        DB::table('agencies')->insert([
            'name' => 'Quedb Edtech',
            'domain'=>'quedb.test',
            'settings' => '{"name":"Quedb Edtech Private Limited","theme":"metronic7","favicon_link":"https:\/\/keenthemes.com\/metronic\/assets\/favicon.ico","meta_title":"Quedb Network","logo":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAQlBMVEX///80m8Yll8Sw0uQclMOoz+O42OgtmcVpr9HY6vJSp8zx9/qJwNrt9vmmzeEOksHf7PTH3+yWx95EosqAu9gAjb+O5uvOAAABOklEQVR4nO3dQVLCQBRFUYwhEIFEQfa/VcupEwfdlfeBc3Zwh7/qdfVuBwAAAAB583txn62FyzqUtk6thfvhrbRBoUKFcQoVKsxTqFBhnkKFCvMUKlSYp1ChwjyFChXmKVSoME+hQoV5ChX+7mnG0u7NhZe5uFNrIQAAj8BWP81WX6HCPIUKFeYpVKgwT6FChXkKFSrMU6hQYZ5ChQrzFCpUmKdQocI8hQpfofD59zTzsi9tad5EAQAAW5in4ry3+Nfz3/gK0xQqVJinUKHCPIUKFeYpVKgwT6FChXkKFSrMU6hQYZ5ChQrzFCpUmNehcDyUNjYXTsfivloLAQB4QdfbR1+3an92nXsfY+slnfTH+dC5cFS4NYUKFeYpVKgwT6FChXkKFSrM++79Gf29WuGpu3QRAAAAsJkf6/OCs/XAUncAAAAASUVORK5CYII="}'
        ]);
    }
}
