<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = [
            "0" => [
                'title'     => 'Острозька академія',
                'parent_id' => 1,
            ],

            "1" => [
                'title'     => 'Головний корпус',
                'parent_id' => 1,
            ],
            "2" => [
                 'title'     => 'Гуманітарний корпус',
                 'parent_id' => 1,
            ],
            "3" => [
                'title'     => 'Старомонастирський корпус',
                'parent_id' => 1,
            ],
            "4" => [
                 'title'     => 'Наукова бібліотека',
                 'parent_id' => 1,
            ],
            "5" => [
                'title'     => 'Господарська частина',
                'parent_id' => 1,
            ],
            "6" => [
                 'title'     => 'Адміністративний корпус',
                 'parent_id' => 1,
            ],
            "7" => [
                'title'     => '314 Кафедра держ-прав. дисц.',
                'parent_id' => 3,
            ],
            "8" => [
                 'title'     => '313 Кафедра цив-прав. дисц.',
                 'parent_id' => 3,
            ],
            "9" => [
                'title'     => '305 Кафедра теор. та іст. держ',
                'parent_id' => 3,
            ],
            "10" => [
                 'title'     => '315 Кафедра крим-прав. дисц.',
                 'parent_id' => 3,
            ],
            "11" => [
                'title'     => 'Кафедра фінансів',
                'parent_id' => 2,
            ],
            "12" => [
                 'title'     => 'Кафедра економ-мат. модел.',
                 'parent_id' => 2,
            ],
            "13" => [
                'title'     => 'Кафедра економ. теорії, менедж.',
                'parent_id' => 2,
            ],
            "14" => [
                 'title'     => 'Кафедра індоєвроп. мов',
                 'parent_id' => 2,
            ],
            "15" => [
                'title'     => 'Кафедра англ. мови та літ-ри',
                'parent_id' => 2,
            ],
            "16" => [
                 'title'     => 'Кафедра міжнар. мовн. комунік.',
                 'parent_id' => 2,
            ],
            "17" => [
                'title'     => 'Кафедра англ філології',
                'parent_id' => 2,
            ],
            "18" => [
                 'title'     => 'Кафедра історії',
                 'parent_id' => 2,
            ],
            "19" => [
                 'title'     => 'Кафедра країнознавства',
                 'parent_id' => 4,
            ],
            "20" => [
                'title'     => 'Кафедра МВ',
                'parent_id' => 4,
            ],
            "21" => [
                 'title'     => '203 Кафедра культур. та філософії',
                 'parent_id' => 3,
            ],
            "22" => [
                 'title'     => '205 Кафедра журналістики',
                 'parent_id' => 3,
            ],
            "23" => [
                'title'     => '201 Кафедра укр. мови і літ-ри',
                'parent_id' => 3,
            ],
            "24" => [
                 'title'     => '414 Кафедра політ. та нацбезпеки',
                 'parent_id' => 3,
            ],
            "25" => [
                'title'     => '412 Кафедра гром. здор. та фіз. вих.',
                'parent_id' => 3,
            ],
            "26" => [
                 'title'     => '413 Кафедра псих. та педагогіки',
                 'parent_id' => 3,
            ],
            "27" => [
                'title'     => '415 Кафедра докум-ва та інф. дія-ті',
                'parent_id' => 3,
            ],
            "28" => [
                 'title'     => 'Ректор',
                 'parent_id' => 2,
            ],
            "29" => [
                'title'     => 'Вчена рада',
                'parent_id' => 2,
            ],
            "30" => [
                 'title'     => 'Проректор з наук-пед. роб.',
                 'parent_id' => 2,
            ],
            "31" => [
                'title'     => 'Проректор з навч-вих. роб.',
                'parent_id' => 2,
            ],
            "32" => [
                 'title'     => 'Приймальня ректора',
                 'parent_id' => 2,
            ],
            "33" => [
                'title'     => 'Пом. ректора зі стратег. розв.',
                'parent_id' => 2,
            ],
            "34" => [
                 'title'     => 'Пом. ректора з осв. мен-',
                 'parent_id' => 2,
            ],
            "35" => [
                'title'     => 'Науковий відділ',
                'parent_id' => 2,
            ],
            "36" => [
                 'title'     => 'Редакц-видав. відділ',
                 'parent_id' => 6,
            ],
            "37" => [
                'title'     => 'Навч-методичний відділ',
                'parent_id' => 2,
            ],
            "38" => [
                 'title'     => 'Музей історії НаУОА',
                 'parent_id' => 2,
            ],
            "39" => [
                 'title'     => 'Інформа-рекламний відділ',
                 'parent_id' => 2,
            ],
            "40" => [
                'title'     => 'Школа освітніх інновацій',
                'parent_id' => 3,
            ],
            "41" => [
                 'title'     => 'Пом. ректора з адмін-господ.',
                 'parent_id' => 2,
            ],
            "42" => [
                 'title'     => 'Відділ будівництва ',
                 'parent_id' => 7,
            ],
            "43" => [
                'title'     => 'Відділ кадрів',
                'parent_id' => 7,
            ],
            "44" => [
                 'title'     => 'Головний бухгалтер',
                 'parent_id' => 7,
            ],
            "45" => [
                'title'     => 'Бухгалтерія',
                'parent_id' => 7,
            ],
            "46" => [
                 'title'     => 'Фін-плановий відділ',
                 'parent_id' => 7,
            ],
            "47" => [
                'title'     => 'Юридичний відділ',
                'parent_id' => 7,
            ],
            "48" => [
                 'title'     => 'Відділ міжнар зв\'язків',
                 'parent_id' => 7,
            ],
            "49" => [
                'title'     => 'ІТЦ',
                'parent_id' => 2,
            ],
            "50" => [
                 'title'     => 'IT Hub',
                 'parent_id' => 7,
            ],
            "51" => [
                'title'     => 'Інженер з охорони праці',
                'parent_id' => 6,
            ],
            "52" => [
                 'title'     => 'Юридична клініка',
                 'parent_id' => 5,
            ],
            "53" => [
                'title'     => 'Пров. фах. з діловодства',
                'parent_id' => 2,
            ],
            "54" => [
                 'title'     => 'Професіонал з антикор. дія-ті',
                 'parent_id' => 2,
            ],
            "55" => [
                'title'     => 'ННЦЗДН',
                'parent_id' => 4,
            ],
            "56" => [
                 'title'     => '407 Деканат ПІМу, декан ПІМу',
                 'parent_id' => 3,
            ],
            "57" => [
                'title'     => 'Деканат економічний',
                'parent_id' => 2,
            ],
            "58" => [
                 'title'     => 'Декан економічний',
                 'parent_id' => 2,
            ],
            "59" => [
                 'title'     => 'Деканат РГМ',
                 'parent_id' => 2,
            ],
            "60" => [
                'title'     => 'Декан РГМ',
                'parent_id' => 2,
            ],
            "61" => [
                 'title'     => 'Деканат МВ',
                 'parent_id' => 4,
            ],
            "62" => [
                 'title'     => 'Декан МВ',
                 'parent_id' => 4,
            ],
            "63" => [
                'title'     => '214 Деканат Гуманітарний',
                'parent_id' => 3,
            ],
            "64" => [
                 'title'     => 'Декан Гуманітарний',
                 'parent_id' => 3,
            ],
            "65" => [
                'title'     => 'Актова зала',
                'parent_id' => 2,
            ],
            "66" => [
                 'title'     => 'Ресурсний РГМ',
                 'parent_id' => 2,
            ],
            "67" => [
                'title'     => 'Архів',
                'parent_id' => 5,
            ],
            "68" => [
                 'title'     => 'Братство спудеїв',
                 'parent_id' => 3,
            ],
            "69" => [
                 'title'     => 'Відділ обробки літератури',
                 'parent_id' => 5,
            ],
            "70" => [
                'title'     => 'Відділ паспортний ',
                'parent_id' => 6,
            ],
            "71" => [
                 'title'     => 'Директор бібліотеки',
                 'parent_id' => 5,
            ],
            "72" => [
                 'title'     => 'Директор ННЦЗДН',
                 'parent_id' => 4,
            ],
            "73" => [
                'title'     => 'Інститут діаспори',
                'parent_id' => 1,
            ],
            "74" => [
                 'title'     => 'Комп\'ютерний центр',
                 'parent_id' => 1,
            ],
            "75" => [
                'title'     => 'Прохідна центральна',
                'parent_id' => 1,
            ],
            "76" => [
                 'title'     => 'Студ. відділ кадрів',
                 'parent_id' => 2,
            ],
            "77" => [
                'title'     => 'Чергова головного корпусу',
                'parent_id' => 2,
            ],
            "78" => [
                 'title'     => 'Медпункт',
                 'parent_id' => 6,
            ],
            "79" => [
                 'title'     => '202 J-Lab',
                 'parent_id' => 3,
            ],
            "80" => [
                'title'     => 'Кругла читальна зала',
                'parent_id' => 5,
            ],
            "81" => [
                 'title'     => 'Читальна зала бібліотеки',
                 'parent_id' => 5,
            ],
            "82" => [
                 'title'     => 'КК 19',
                 'parent_id' => 2,
            ],
            "83" => [
                'title'     => 'КК 20',
                'parent_id' => 2,
            ],
            "84" => [
                 'title'     => 'КК 21',
                 'parent_id' => 2,
            ],
            "85" => [
                'title'     => 'КК 22',
                'parent_id' => 2,
            ],
            "86" => [
                 'title'     => 'КК 23',
                 'parent_id' => 2,
            ],
            "87" => [
                'title'     => 'КК 32',
                'parent_id' => 2,
            ],
            "88" => [
                 'title'     => 'КК 101',
                 'parent_id' => 3,
            ],
            "89" => [
                 'title'     => 'КК 102',
                 'parent_id' => 3,
            ],
            "90" => [
                'title'     => 'КК 211',
                'parent_id' => 3,
            ],
            "91" => [
                 'title'     => 'КК 212',
                 'parent_id' => 3,
            ],
            "92" => [
                 'title'     => 'КК 309',
                 'parent_id' => 3,
            ],
            "93" => [
                'title'     => 'КК 310',
                'parent_id' => 3,
            ],
            "94" => [
                 'title'     => 'ГЖ Академічний дім',
                 'parent_id' => 1,
            ],
            "95" => [
                'title'     => 'ГЖ 2',
                'parent_id' => 1,
            ],
            "96" => [
                 'title'     => 'ГЖ 3',
                 'parent_id' => 1,
            ],
            "97" => [
                'title'     => 'ГЖ 4',
                'parent_id' => 1,
            ],
            "98" => [
                 'title'     => 'ГЖ 5',
                 'parent_id' => 1,
            ],
            "99" => [
                 'title'     => 'ГЖ 6',
                 'parent_id' => 1,
            ],
            "100" => [
                'title'     => 'ГЖ 7',
                'parent_id' => 1,
            ],
            "101" => [
                 'title'     => 'ГЖ 8',
                 'parent_id' => 1,
            ],
            "102" => [
                 'title'     => 'ГЖ 9',
                 'parent_id' => 1,
            ],
            "103" => [
                'title'     => 'ГЖ 10',
                'parent_id' => 1,
            ],
            "104" => [
                 'title'     => 'Стадіон',
                 'parent_id' => 1,
            ],
            "105" => [
                'title'     => 'Спортзал',
                'parent_id' => 1,
            ],
            "106" => [
                 'title'     => 'КМЦ',
                 'parent_id' => 1,
            ],
            "107" => [
                'title'     => '1',
                'parent_id' => 2,
            ],
            "108" => [
                 'title'     => '2',
                 'parent_id' => 2,
            ],
            "109" => [
                 'title'     => '3',
                 'parent_id' => 2,
            ],
            "110" => [
                'title'     => '4',
                'parent_id' => 2,
            ],
            "111" => [
                 'title'     => '5',
                 'parent_id' => 2,
            ],
            "112" => [
                 'title'     => '6',
                 'parent_id' => 2,
            ],
            "113" => [
                'title'     => '7',
                'parent_id' => 2,
            ],
            "114" => [
                 'title'     => '8',
                 'parent_id' => 2,
            ],
            "115" => [
                'title'     => '9',
                'parent_id' => 2,
            ],
            "116" => [
                 'title'     => '10',
                 'parent_id' => 2,
            ],
            "117" => [
                'title'     => '11',
                'parent_id' => 2,
            ],
            "118" => [
                 'title'     => '12',
                 'parent_id' => 2,
            ],
            "119" => [
                 'title'     => '13',
                 'parent_id' => 2,
            ],
            "120" => [
                 'title'     => '14',
                 'parent_id' => 2,
            ],
            "121" => [
                 'title'     => '15',
                 'parent_id' => 2,
            ],
            "122" => [
                 'title'     => '16',
                 'parent_id' => 2,
            ],
            "123" => [
                 'title'     => '17',
                 'parent_id' => 2,
            ],
            "124" => [
                 'title'     => '18',
                 'parent_id' => 2,
            ],
            "125" => [
                 'title'     => '24',
                 'parent_id' => 2,
            ],
            "126" => [
                 'title'     => '25',
                 'parent_id' => 2,
            ],
            "127" => [
                 'title'     => '26',
                 'parent_id' => 2,
            ],
            "128" => [
                 'title'     => '27',
                 'parent_id' => 2,
            ],
            "129" => [
                 'title'     => '28',
                 'parent_id' => 2,
            ],
            "130" => [
                 'title'     => '29',
                 'parent_id' => 2,
            ],
            "131" => [
                 'title'     => '30',
                 'parent_id' => 2,
            ],
            "132" => [
                 'title'     => '31',
                 'parent_id' => 2,
            ],
            "133" => [
                 'title'     => '33',
                 'parent_id' => 2,
            ],
            "134" => [
                 'title'     => '34',
                 'parent_id' => 2,
            ],
            "135" => [
                 'title'     => '35',
                 'parent_id' => 2,
            ],
            "136" => [
                 'title'     => '36',
                 'parent_id' => 2,
            ],
            "137" => [
                 'title'     => '37',
                 'parent_id' => 2,
            ],
            "138" => [
                 'title'     => '38',
                 'parent_id' => 4,
            ],
            "139" => [
                 'title'     => '39',
                 'parent_id' => 4,
            ],
            "140" => [
                 'title'     => '40',
                 'parent_id' => 4,
            ],
            "141" => [
                 'title'     => '41',
                 'parent_id' => 4,
            ],
            "142" => [
                 'title'     => '42',
                 'parent_id' => 4,
            ],
            "143" => [
                 'title'     => '43',
                 'parent_id' => 4,
            ],
            "144" => [
                 'title'     => '46',
                 'parent_id' => 2,
            ],
            "145" => [
                 'title'     => '47',
                 'parent_id' => 2,
            ],
            "146" => [
                 'title'     => '48',
                 'parent_id' => 2,
            ],
            "147" => [
                 'title'     => '49',
                 'parent_id' => 2,
            ],
            "148" => [
                 'title'     => '50',
                 'parent_id' => 2,
            ],
            "149" => [
                 'title'     => '53',
                 'parent_id' => 2,
            ],
            "150" => [
                 'title'     => '54',
                 'parent_id' => 2,
            ],
            "151" => [
                 'title'     => '55',
                 'parent_id' => 2,
            ],
            "152" => [
                 'title'     => '56',
                 'parent_id' => 2,
            ],
            "153" => [
                 'title'     => '57',
                 'parent_id' => 2,
            ],
            "154" => [
                 'title'     => '61',
                 'parent_id' => 2,
            ],
            "155" => [
                 'title'     => '62',
                 'parent_id' => 2,
            ],
            "156" => [
                 'title'     => '63',
                 'parent_id' => 2,
            ],
            "157" => [
                 'title'     => '64',
                 'parent_id' => 2,
            ],
            "158" => [
                 'title'     => '65',
                 'parent_id' => 2,
            ],
            "159" => [
                 'title'     => '66',
                 'parent_id' => 2,
            ],
            "160" => [
                 'title'     => '67',
                 'parent_id' => 2,
            ],
            "161" => [
                 'title'     => '68',
                 'parent_id' => 2,
            ],
            "162" => [
                 'title'     => '69',
                 'parent_id' => 2,
            ],
            "163" => [
                 'title'     => '70',
                 'parent_id' => 2,
            ],
            "164" => [
                 'title'     => '71',
                 'parent_id' => 2,
            ],
            "165" => [
                 'title'     => '72',
                 'parent_id' => 2,
            ],
            "166" => [
                 'title'     => '73',
                 'parent_id' => 2,
            ],
            "167" => [
                 'title'     => '74',
                 'parent_id' => 2,
            ],
            "168" => [
                 'title'     => 'П1',
                 'parent_id' => 2,
            ],
            "169" => [
                 'title'     => 'П2',
                 'parent_id' => 2,
            ],
            "170" => [
                 'title'     => 'П3',
                 'parent_id' => 2,
            ],
            "171" => [
                 'title'     => 'П4',
                 'parent_id' => 2,
            ],
            "172" => [
                 'title'     => 'П5',
                 'parent_id' => 2,
            ],
            "173" => [
                 'title'     => 'АГ1',
                 'parent_id' => 6,
            ],
            "174" => [
                 'title'     => 'АГ2',
                 'parent_id' => 6,
            ],
            "175" => [
                 'title'     => 'АГ3',
                 'parent_id' => 6,
            ],
            "176" => [
                 'title'     => 'АГ4',
                 'parent_id' => 6,
            ],
            "177" => [
                 'title'     => '103',
                 'parent_id' => 3,
            ],
            "178" => [
                 'title'     => '104',
                 'parent_id' => 3,
            ],
            "179" => [
                 'title'     => '105',
                 'parent_id' => 3,
            ],
            "180" => [
                 'title'     => '106',
                 'parent_id' => 3,
            ],
            "181" => [
                 'title'     => '107',
                 'parent_id' => 3,
            ],
            "182" => [
                 'title'     => '108',
                 'parent_id' => 3,
            ],
            "183" => [
                 'title'     => '109',
                 'parent_id' => 3,
            ],
            "184" => [
                 'title'     => '110',
                 'parent_id' => 3,
            ],
            "185" => [
                 'title'     => '111',
                 'parent_id' => 3,
            ],
            "186" => [
                 'title'     => '112',
                 'parent_id' => 3,
            ],
            "187" => [
                 'title'     => '206',
                 'parent_id' => 3,
            ],
            "188" => [
                 'title'     => '204',
                 'parent_id' => 3,
            ],
            "189" => [
                 'title'     => '207',
                 'parent_id' => 3,
            ],
            "190" => [
                 'title'     => '208',
                 'parent_id' => 3,
            ],
            "191" => [
                 'title'     => '209',
                 'parent_id' => 3,
            ],
            "192" => [
                 'title'     => '210',
                 'parent_id' => 3,
            ],
            "193" => [
                 'title'     => '211',
                 'parent_id' => 3,
            ],
            "194" => [
                 'title'     => '212',
                 'parent_id' => 3,
            ],
            "195" => [
                 'title'     => '213',
                 'parent_id' => 3,
            ],
            "196" => [
                 'title'     => '215',
                 'parent_id' => 3,
            ],
            "197" => [
                 'title'     => '216',
                 'parent_id' => 3,
            ],
            "198" => [
                 'title'     => '217',
                 'parent_id' => 3,
            ],
            "199" => [
                 'title'     => '218',
                 'parent_id' => 3,
            ],
            "200" => [
                 'title'     => '301',
                 'parent_id' => 3,
            ],
            "201" => [
                 'title'     => '302',
                 'parent_id' => 3,
            ],
            "202" => [
                 'title'     => '303',
                 'parent_id' => 3,
            ],
            "203" => [
                 'title'     => '304',
                 'parent_id' => 3,
            ],
            "204" => [
                 'title'     => '306',
                 'parent_id' => 3,
            ],
            "205" => [
                 'title'     => '307',
                 'parent_id' => 3,
            ],
            "206" => [
                 'title'     => '308',
                 'parent_id' => 3,
            ],
            "207" => [
                 'title'     => '309',
                 'parent_id' => 3,
            ],
            "208" => [
                 'title'     => '310',
                 'parent_id' => 3,
            ],
            "209" => [
                 'title'     => '311',
                 'parent_id' => 3,
            ],
            "210" => [
                 'title'     => '312',
                 'parent_id' => 3,
            ],
            "211" => [
                 'title'     => '316',
                 'parent_id' => 3,
            ],
            "212" => [
                 'title'     => '401',
                 'parent_id' => 3,
            ],
            "213" => [
                 'title'     => '402',
                 'parent_id' => 3,
            ],
            "214" => [
                 'title'     => '403',
                 'parent_id' => 3,
            ],
            "215" => [
                 'title'     => '404',
                 'parent_id' => 3,
            ],
            "216" => [
                 'title'     => '405',
                 'parent_id' => 3,
            ],
            "217" => [
                 'title'     => '406',
                 'parent_id' => 3,
            ],
            "218" => [
                 'title'     => '408',
                 'parent_id' => 3,
            ],
            "219" => [
                 'title'     => '409',
                 'parent_id' => 3,
            ],
            "220" => [
                 'title'     => '410',
                 'parent_id' => 3,
            ],
            "221" => [
                 'title'     => '411',
                 'parent_id' => 3,
            ],
            "222" => [
                 'title'     => 'Арт-кластер',
                 'parent_id' => 3,
            ],
            "223" => [
                 'title'     => 'Чергова гуманітарного',
                 'parent_id' => 3,
            ],
             "224" => [
                 'title'     => 'Шостак І.В. нов корпус',
                 'parent_id' => 7,
            ],
            "225" => [
                 'title'     => 'Відділ працев. студ.',
                 'parent_id' => 5,
            ]
        ];
        Department::insert($places);
    }
}
