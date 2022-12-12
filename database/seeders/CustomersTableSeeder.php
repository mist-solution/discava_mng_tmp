<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'company_name' => '株式会社MIST solution',
            'business_content' => '・ソフトウェアの設計・開発
            ・コンピュータシステムにおける委託・開発・保守メンテナンス
            ・コンピュータシステムによるパッケージ開発・販売・保守メンテナンス
            ・コンピュータシステム導入及び開発のためのコンサルティング
            ・ネットワークシステム業務
            ・システムエンジニアの派遣',
            'postal_code' => '101-0037',
            'address' => "東京都千代田区神田西福田町4丁目2番",
            'building_name' => "D'sVARIE神田ビル（ユニゾ神田西福田町ビル）4F",
            'tel' => '03-3526-7271',
            'fax' => '03-3526-0271',
            'mail' => 'info@discava.net',
            'add_account' => '1',
            'upd_account' => '1',
            'del_flg' => '0',
        ]);

        for($i = 2; $i < 10; $i++) {

            Customer::create([
                'company_name' => 'テスト法人' . $i,
                'business_content' => '',
                'postal_code' => '101-0000',
                'address' => "東京都",
                'building_name' => "",
                'tel' => '03-8888-9999',
                'fax' => '',
                'mail' => '',
                'add_account' => '1',
                'upd_account' => '1',
                'del_flg' => '0',
            ]);
        }
    }
}
