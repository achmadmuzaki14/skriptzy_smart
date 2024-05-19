<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Criteria;
use Carbon\Carbon;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kriteria Weboender = 4
        $dataWeb = [
            [
                'name' => 'Kemampuan bahasa pemrograman',
                'priority' => 1,
                'community_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan manajemen basis data',
                'priority' => 2,
                'community_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan framework',
                'priority' => 3,
                'community_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan library/package',
                'priority' => 4,
                'community_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataWeb);


        // Kriteria GDSC = 4
        $dataGDSC = [
            [
                'name' => 'Kemampuan bahasa pemrograman',
                'priority' => 1,
                'community_id' => 2,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan library/package',
                'priority' => 2,
                'community_id' => 2,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan framework',
                'priority' => 3,
                'community_id' => 2,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan untuk memberikan ilmu kepada orang lain',
                'priority' => 4,
                'community_id' => 2,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataGDSC);

        // Kriteria MOCAP = 8
        $dataMOCAP = [
            [
                'name' => 'Kemampuan bahasa pemrograman',
                'priority' => 1,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan manajemen basis data',
                'priority' => 2,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan debugging dan troubleshooting',
                'priority' => 3,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Penerapan prinsip UI/UX design',
                'priority' => 4,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan desain arsitektur',
                'priority' => 5,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan library/package',
                'priority' => 6,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan konsep jaringan',
                'priority' => 7,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan Version Control',
                'priority' => 8,
                'community_id' => 3,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        Criteria::insert($dataMOCAP);

        // Kriteria Fun Java = 4
        $dataFunJava = [
            [
                'name' => 'Kemampuan bahasa pemrograman',
                'priority' => 1,
                'community_id' => 4,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan manajemen basis data',
                'priority' => 2,
                'community_id' => 4,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan framework',
                'priority' => 3,
                'community_id' => 4,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan penggunaan library/package',
                'priority' => 4,
                'community_id' => 4,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        Criteria::insert($dataFunJava);

        // Kriteria UINUX = 3
        $dataUINUX = [
            [
                'name' => 'Teknik kreativitas',
                'priority' => 1,
                'community_id' => 5,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Teknik kreativitas',
                'priority' => 2,
                'community_id' => 5,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Tingkat inovasi',
                'priority' => 3,
                'community_id' => 5,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataUINUX);

        // Kriteria UINBUNTU = 6
        $dataUINBUNTU = [
            [
                'name' => 'Networking',
                'priority' => 1,
                'community_id' => 6,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Operating sistem ',
                'priority' => 2,
                'community_id' => 6,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cloud',
                'priority' => 3,
                'community_id' => 6,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Virtualisasi',
                'priority' => 4,
                'community_id' => 6,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Server building',
                'priority' => 5,
                'community_id' => 6,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Infra',
                'priority' => 6,
                'community_id' => 6,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataUINBUNTU);

        // Kriteria ETH0 = 6
        $dataETH0 = [
            [
                'name' => 'Understand and enforce best practices.',
                'priority' => 1,
                'community_id' => 7,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Mengonfigurasi, memonitor, dan mengelola sistem',
                'priority' => 2,
                'community_id' => 7,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Memrogram berbagai tools dalam berbagai bahasa',
                'priority' => 3,
                'community_id' => 7,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Merancang, membangun, dan mengoperasikan teknologi stack',
                'priority' => 4,
                'community_id' => 7,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Scripting proses Linux/Unix dalam berbagai bahasa',
                'priority' => 5,
                'community_id' => 7,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Mengoperasikan berbagai produk cloud',
                'priority' => 6,
                'community_id' => 7,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataETH0);

        // Kriteria DSE = 5
        $dataDSE = [
            [
                'name' => 'Kemampuan Memahami Data',
                'priority' => 1,
                'community_id' => 8,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan Menganalisis Data',
                'priority' => 2,
                'community_id' => 8,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pemahaman Matematika dan Statistik',
                'priority' => 3,
                'community_id' => 8,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pemahaman Machine Learning',
                'priority' => 4,
                'community_id' => 8,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kemampuan Pemrograman & Visualisasi Data',
                'priority' => 5,
                'community_id' => 8,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataDSE);

        // Kriteria MAMUD = 3
        $dataMamud = [
            [
                'name' => 'Banyaknya jam terbang / pengalaman',
                'priority' => 1,
                'community_id' => 9,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Menguasai beberapa software editing / menguasai software unity dan bahasa pemrograman C# untuk game dev',
                'priority' => 2,
                'community_id' => 9,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kreativitas dan Inovasi',
                'priority' => 3,
                'community_id' => 9,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        Criteria::insert($dataMamud);

         // Kriteria Ontaki = 6
         $dataOntaki = [
            [
                'name' => 'Kemampuan membuat prototipe dan model ',
                'priority' => 1,
                'community_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pengelasan dan penyolderan',
                'priority' => 2,
                'community_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pemrograman',
                'priority' => 3,
                'community_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pengujian dan kontrol kualitas',
                'priority' => 4,
                'community_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pengetahuan tentang antarmuka manusia-mesin',
                'priority' => 5,
                'community_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pemodelan komputer',
                'priority' => 6,
                'community_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

         Criteria::insert($dataOntaki);
    }
}
