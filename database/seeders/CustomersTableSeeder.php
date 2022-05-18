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
            'code' => 'MIST',
            'company_name' => '株式会社MIST solution 本社',
            'business_content' => '・ソフトウェアの設計・開発
            ・コンピュータシステムにおける委託・開発・保守メンテナンス
            ・コンピュータシステムによるパッケージ開発・販売・保守メンテナンス
            ・コンピュータシステム導入及び開発のためのコンサルティング
            ・ネットワークシステム業務
            ・システムエンジニアの派遣',
            'postal_code' => '101-0037',
            'address' => "東京都千代田区神田西福田町4丁目2番D'sVARIE神田ビル（ユニゾ神田西福田町ビル）4F",
            'tel' => '03-3526-7271',
            'fax' => '03-3526-0271',
        ]);

        Customer::create([
            'code' => 'MIST_BRANCH',
            'company_name' => '株式会社MIST solution 高松支店',
            'business_content' => '・ソフトウェアの設計・開発
            ・コンピュータシステムにおける委託・開発・保守メンテナンス
            ・コンピュータシステムによるパッケージ開発・販売・保守メンテナンス
            ・コンピュータシステム導入及び開発のためのコンサルティング
            ・ネットワークシステム業務
            ・システムエンジニアの派遣',
            'postal_code' => '760-0028',
            'address' => "香川県高松市鍛冶屋町3番地 香川三友ビル3F",
            'tel' => '087-3873-2502',
            'fax' => '087-3873-2503',
        ]);
    }
}
