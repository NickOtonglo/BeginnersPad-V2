<?php

namespace Database\Seeders;

use App\Models\ZoneCounty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ZoneCountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ZoneCounty::factory()
                ->count(47)
                ->state(new Sequence(
                    [
                        'name' => 'Mombasa',
                        'code' => '001',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kwale',
                        'code' => '002',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kilifi',
                        'code' => '003',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Tana River',
                        'code' => '004',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Lamu',
                        'code' => '005',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Taita-Taveta',
                        'code' => '006',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Garissa',
                        'code' => '007',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Wajir',
                        'code' => '008',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Mandera',
                        'code' => '009',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Marsabit',
                        'code' => '010',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Isiolo',
                        'code' => '011',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Meru',
                        'code' => '012',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Tharaka-Nithi',
                        'code' => '013',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Embu',
                        'code' => '014',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kitui',
                        'code' => '015',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Machakos',
                        'code' => '016',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Makueni',
                        'code' => '017',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Nyandarua',
                        'code' => '018',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Nyeri',
                        'code' => '019',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kirinyaga',
                        'code' => '020',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Murang’a',
                        'code' => '021',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kiambu',
                        'code' => '022',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Turkana',
                        'code' => '023',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'West Pokot',
                        'code' => '024',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Samburu',
                        'code' => '025',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Trans-Nzoia',
                        'code' => '026',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Uasin Gishu',
                        'code' => '027',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Elgeyo-Marakwet',
                        'code' => '028',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Nandi',
                        'code' => '029',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Baringo',
                        'code' => '030',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Laikipia',
                        'code' => '031',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Nakuru',
                        'code' => '032',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Narok',
                        'code' => '033',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kajiado',
                        'code' => '034',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kericho',
                        'code' => '035',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Bomet',
                        'code' => '036',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kakamega',
                        'code' => '037',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Vihiga',
                        'code' => '038',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Bungoma',
                        'code' => '039',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Busia',
                        'code' => '040',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Siaya',
                        'code' => '041',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kisumu',
                        'code' => '042',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Homa Bay',
                        'code' => '043',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Migori',
                        'code' => '044',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Kisii',
                        'code' => '045',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Nyamira',
                        'code' => '046',
                        'country_id' => '1',
                    ],
                    [
                        'name' => 'Nairobi',
                        'code' => '047',
                        'country_id' => '1',
                    ],
                ))->create();
    }
}
