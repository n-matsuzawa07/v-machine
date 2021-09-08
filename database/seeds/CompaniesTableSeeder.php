<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('companies')->insert([
          [
            'company_name'=>'伊藤園',
            'street_address'=>'東京都品川区品川111-11',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ],
          [
            'company_name'=>'コカ・コーラ',
            'street_address'=>'東京都品川区大崎222-22',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ],
          [
            'company_name'=>'アサヒ',
            'street_address'=>'東京都品川区品川333-33',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ],
          [
            'company_name'=>'キリン',
            'street_address'=>'東京都品川区品川444-44',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ],
          [
            'company_name'=>'サントリー',
            'street_address'=>'東京都品川区品川555-55',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ],
          [
            'company_name'=>'大塚製薬',
            'street_address'=>'東京都品川区品川666-66',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ],
          [
            'company_name'=>'DyDo',
            'street_address'=>'東京都品川区品川777-77',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          ]
          ]);
    }
}