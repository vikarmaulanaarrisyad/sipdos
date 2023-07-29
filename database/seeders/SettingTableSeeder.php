<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new Setting;
        $setting->nama_aplikasi = 'SIPDOS';
        $setting->nama_singkatan = 'SIPDOS';
        $setting->diskripsi_aplikasi = 'Sistem Informasi Penilaian Dosen';
        $setting->logo_aplikasi = 'default.jpg';
        $setting->logo_login = 'default.jpg';
        $setting->save();
    }
}
