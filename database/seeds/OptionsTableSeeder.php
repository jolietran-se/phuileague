<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            [
                'type_code' => 'AGES',
                'type_id' => '1',
                'name' => '< 15',
            ],
            [
                'type_code' => 'AGES',
                'type_id' => '2',
                'name' => '15-20',
            ],
            [
                'type_code' => 'AGES',
                'type_id' => '3',
                'name' => '20-25',
            ],
            [
                'type_code' => 'AGES',
                'type_id' => '4',
                'name' => '25-30',
            ],
            [
                'type_code' => 'AGES',
                'type_id' => '5',
                'name' => '> 30',
            ],
            [
                'type_code' => 'AGES',
                'type_id' => '6',
                'name' => 'Nhiều độ tuổi',
            ],

            [
                'type_code' => 'CLUBTYPE',
                'type_id' => '1',
                'name' => 'Chuyên nghiệp',
            ],
            [
                'type_code' => 'CLUBTYPE',
                'type_id' => '2',
                'name' => 'Bán chuyên Nghiệp',
            ],
            [
                'type_code' => 'CLUBTYPE',
                'type_id' => '3',
                'name' => 'Phủi',
            ],
            [
                'type_code' => 'CLUBTYPE',
                'type_id' => '4',
                'name' => 'Vui là chính',
            ],
            [
                'type_code' => 'CLUBTYPE',
                'type_id' => '5',
                'name' => 'Khác',
            ],

            [
                'type_code' => 'PLAYER_POSITION',
                'type_id' => '1',
                'name' => 'Thủ môn',
            ],
            [
                'type_code' => 'PLAYER_POSITION',
                'type_id' => '2',
                'name' => 'Hậu vệ',
            ],
            [
                'type_code' => 'PLAYER_POSITION',
                'type_id' => '3',
                'name' => 'Tiền vệ',
            ],
            [
                'type_code' => 'PLAYER_POSITION',
                'type_id' => '4',
                'name' => 'Tiền đạo',
            ],
            [
                'type_code' => 'PLAYER_POSITION',
                'type_id' => '5',
                'name' => 'Khác',
            ],

            [
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '1',
                'name' => 'Vận động viên',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '2',
                'name' => 'HLV Trưởng',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '3',
                'name' => 'HLV Thủ môn',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '4',
                'name' => 'HLV Thể lực',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '5',
                'name' => 'Trợ lý HLV',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '6',
                'name' => 'Đội trưởng',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '7',
                'name' => 'Đội phó',
            ],[
                'type_code' => 'PLAYER_ROLE',
                'type_id' => '8',
                'name' => 'Ông bầu',
            ],

        ]);
    }
}
