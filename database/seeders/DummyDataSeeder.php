<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Murid;  
use App\Models\Guru;
use App\Models\Request;
use App\Models\Negotiation;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234'),
            'role' => 'admin'
        ]);

        $muridUsers = [];
        $guruUsers = [];

        // Buat 5 murid
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Murid ' . $i,
                'email' => 'murid' . $i . '@example.com',
                'password' => Hash::make('1234'),
                'role' => 'murid'
            ]);

            Murid::create([
                'user_id' => $user->id,
                'bidang_pelatihan' => $this->getRandomBidangPelatihan(),
                'lokasi' => $this->getRandomLokasi(),
                'file_identitas' => 'storage/murid/identitas/identitas_' . $user->id . '.jpg'
            ]);

            $muridUsers[] = $user;
        }

        // Buat 5 guru
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Guru ' . $i,
                'email' => 'guru' . $i . '@example.com',
                'password' => Hash::make('1234'),
                'role' => 'guru'
            ]);

            Guru::create([
                'user_id' => $user->id,
                'keahlian' => $this->getRandomKeahlian(),
                'lokasi' => $this->getRandomLokasi(),
                'foto_profile' => 'storage/guru/profile/profile_' . $user->id . '.jpg',
                'foto_sertifikat' => 'storage/guru/sertifikat/sertifikat_' . $user->id . '.jpg',
                'foto_ktp' => 'storage/guru/ktp/ktp_' . $user->id . '.jpg'
            ]);

            $guruUsers[] = $user;
        }

        // Seed requests (3-5 per murid)
        foreach ($muridUsers as $muridUser) {
            $randomGurus = collect($guruUsers)->random(rand(3, 5));
            foreach ($randomGurus as $guruUser) {
                $request = Request::create([
                    'murid_id' => $muridUser->murid->id,
                    'guru_id' => $guruUser->guru->id,
                    'pesan' => $this->getRandomPesanRequest(),
                    'status' => $this->getRandomStatus(),
                    'tanggal_request' => now()->subDays(rand(1, 30))
                ]);

                if (rand(0, 1)) {
                    $this->seedNegotiations($request, $muridUser, $guruUser);
                }
            }
        }
    }

    private function seedNegotiations($request, $muridUser, $guruUser)
    {
        Negotiation::create([
            'request_id' => $request->id,
            'user_id' => $muridUser->id,
            'pesan' => 'Saya ingin menawar harga untuk pelatihan ini',
            'harga' => rand(50000, 150000),
            'waktu_pelaksanaan' => now()->addDays(rand(1, 14))
        ]);

        Negotiation::create([
            'request_id' => $request->id,
            'user_id' => $guruUser->id,
            'pesan' => 'Saya bisa menurunkan harga menjadi Rp' . rand(100000, 200000) . ' per jam',
            'harga' => rand(100000, 200000),
            'waktu_pelaksanaan' => now()->addDays(rand(7, 21))
        ]);

        if (rand(0, 1)) {
            Negotiation::create([
                'request_id' => $request->id,
                'user_id' => $muridUser->id,
                'pesan' => 'Baik, saya setuju dengan harga tersebut',
                'harga' => rand(100000, 200000),
                'waktu_pelaksanaan' => now()->addDays(rand(7, 21))
            ]);

            $request->update([
                'status' => 'deal',
                'tanggal_deal' => now()
            ]);
        }
    }

    private function getRandomBidangPelatihan()
    {
        $bidang = ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa Inggris', 'Bahasa Jepang', 'Pemrograman', 'Desain Grafis', 'Musik', 'Olahraga'];
        return $bidang[array_rand($bidang)];
    }

    private function getRandomKeahlian()
    {
        $keahlian = ['Matematika Lanjut', 'Fisika Kuantum', 'Kimia Organik', 'Biologi Molekuler', 'IELTS Preparation', 'JLPT N2-N1', 'Web Development', 'Mobile Development', 'UI/UX Design', 'Piano Klasik', 'Basketball Training'];
        return $keahlian[array_rand($keahlian)];
    }

    private function getRandomLokasi()
    {
        $lokasi = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Online'];
        return $lokasi[array_rand($lokasi)];
    }

    private function getRandomPesanRequest()
    {
        $pesan = ['Saya ingin belajar dengan bapak/ibu guru', 'Mohon bimbingannya untuk pelatihan ini', 'Saya tertarik dengan keahlian yang bapak/ibu miliki', 'Bisakah kita mengatur jadwal untuk pelatihan?', 'Saya membutuhkan tutor untuk membantu saya memahami materi ini'];
        return $pesan[array_rand($pesan)];
    }

    private function getRandomStatus()
    {
        $status = ['pending', 'ditolak', 'disetujui', 'deal'];
        $weights = [40, 20, 30, 10];
        $rand = rand(1, array_sum($weights));
        
        $cumulative = 0;
        foreach ($status as $key => $value) {
            $cumulative += $weights[$key];
            if ($rand <= $cumulative) {
                return $value;
            }
        }

        return 'pending';
    }
}
