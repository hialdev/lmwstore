<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(['key' => 'logo_site','content' => '/assets/images/lmw-logo.png']);
        Setting::create(['key' => 'logo_favicon','content' => '/assets/images/lmw-logo.png']);
        Setting::create(['key' => 'desc_site','content' => 'PT.Langgeng Makmur Wijaya berdiri sejak tahun 2015 dan merupakan perusahaan yang bergerak dibidang :Edukasi, fashion, Batik atau kearifan lokal dan pengadaan. Salah satu visi dan misi kami adalah mengangkat dan mempromosikan kearifan lokal juga pengembangan keahlian sumber daya manusia serta membuka kesempatan produk lokal kita untuk lebih dikenal dan diminati di dalam dan luar negeri. Hal itu bertujuan untuk membantu bergeraknya perekonomian para pelaku usaha yang tergabung dalam IMKM / IKM / Jak Preneur.']);
        Setting::create(['key' => 'wa_admin','content' => '6289671052050']);
        Setting::create(['key' => 'address','content' => 'Jl. Paus No.90, RT.1/RW.8, jati, Rawamangun, Kec. Pulo Gadung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13220']);
        Setting::create(['key' => 'gmaps','content' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.51252896939!2d106.88925711536972!3d-6.195903262426719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4bfa036c11b%3A0xce36f6058e6d20ea!2sJl.%20Paus%20No.90%2C%20RT.1%2FRW.8%2C%20Jati%2C%20Kec.%20Pulo%20Gadung%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2013220!5e0!3m2!1sen!2sid!4v1646622680776!5m2!1sen!2sid']);
        Setting::create(['key' => 'webmail','content' => 'mnuralif63@gmail.com']);
    }
}
