<?php

namespace Database\Seeders\Pages;

use App\Models\Declinat;
use App\Models\Metat;
use App\Models\Page;
use App\Models\Territ\Country;
use App\Models\Territ\District;
use App\Models\Territ\Province;
use App\Models\Territ\Settlement;
use App\Models\Territ\SettlementDivision;
use App\Models\Territ\SettlementSector;
use App\Models\Territ\SettlementType;
use App\Models\Territ\Zone;
use Database\Seeders\Helpers\FillImgFromStor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

// php artisan db:seed --class=Database\\Seeders\\Pages\\GeoSeeder
class GeoSeeder extends Seeder
{
    use FillImgFromStor;

    public $sourceUrl = 'http://host.docker.internal:600';
    public $csvPath;
    public $country;

    public $zonesAbbreviation = [
        'Северо-Западный ФО'      => 'СЗФО',
        'Сибирский ФО'            => 'СФО',
        'Центральный ФО'          => 'ЦФО',
        'Южный ФО'                => 'ЮФО',
        'Уральский ФО'            => 'УФО',
        'Приволжский ФО'          => 'ПФО',
        'Северо-Кавказский ФО'    => 'СКФО',
    ];

    public function __construct()
    {
        $this->csvPath = Storage::disk('upload')->path('settlements-fias22.csv');

        $this->country = Country::firstOrCreate(
            ['name' => 'Россия']
        );
    }

    public function run(): void
    {
        DB::beginTransaction();

        $this->basePageDetermine();

        $this->installRussiaBigSettelments();

        // DB::rollBack();
        DB::commit();
        Cache::flush();
    }

    public function basePageDetermine(): void
    {
        try {
            $page = Page::firstOrNew(['name' => 'Регионы']);
            $page->slug = 'regions';
            $page->parent_id = 1;
            $page->save();

            $Metat = Metat::updateOrCreate(
                ['city_id' => null, 'metable_type' => $page::class, 'metable_id' => $page->id],
                [
                    'h1' => 'Объекты в России',
                    'subtitle' => 'Объекты недвижимости',
                    'title' => 'Карта покрытия',
                    'keywords' => null,
                    'description' => 'Для любых видов объектов в России.',
                    'form_id' => 'consultation24',
                    'form_subject' => 'Консультация по карте покрытия охранных систем',
                    'form_service_name' => 'Карта покрытия',
                    'city_id' => null,
                ]
            );
            $page->metas()->save($Metat);

            $filePath = 'regions/earth_emblem_doubleheaded_eagle.jpg';
            $f = Storage::disk('upload')->size($filePath);
            $weight = number_format($f / 1048576, 2);
            $this->command->info(
                'пытаемся добавить баннер Россия' . PHP_EOL .
                    ' - img (' . $weight . ') mb : ' . $filePath . PHP_EOL
            );

            $hash = md5(Storage::disk('upload')->get($filePath));
            $existing = $page->getMedia('banners')->first(function ($media) use ($hash) {
                return $media->custom_properties['hash'] ?? null === $hash;
            });

            if ($existing) {
                $this->command->info('Баннер уже прикреплён: ' . $filePath);
            } else {
                $page->addMediaFromDisk($filePath, 'upload')
                    ->preservingOriginal()
                    ->withCustomProperties(['hash' => $hash])
                    ->toMediaCollection('banners');
            }
        } catch (\Throwable $e) {
            $this->command->warn('File: ' . $e->getFile() . ' | Line#' . $e->getLine() . ' выброс: ' . $e->getMessage());
            exit;
        }
    }

    public function installRussiaBigSettelments(): void
    {
        try {
            $csv = array_map('str_getcsv', file($this->csvPath));
            $headers = array_map('trim', array_shift($csv));
            $csvSettelmentsInfo = array_map(function ($row) use ($headers) {
                return array_combine($headers, $row);
            }, $csv);

            $russiaBigSettelmentList = json_decode($this->getRussiaBigSettelments(), true);

            $this->command->info('Запущено сопоставление RussiaBigSettelments данных bitrix и csv, а так же сохранение в базу laravel');

            foreach ($russiaBigSettelmentList as $settelment) {
                $name = $settelment['NAME'];

                $zoneName = $settelment['PARENT_SECTIONS'][0] ?? null;

                $match = collect($csvSettelmentsInfo)->first(function ($row) use ($name, $provinceName) {
                    return $row['settlement'] === $name
                        && $row['region'] === $provinceName;
                });

                if (!$match) {
                    echo "❌ Не найдено соответствие: $name ($provinceName, $zoneName)\n";
                    continue;
                }

                $zone = Zone::firstOrCreate(
                    [
                        'country_id' => $this->country->id,
                        'name' => $zoneName
                    ],
                    [
                        'short_name' => $this->zonesAbbreviation[$zoneName] ?? $zoneName,
                    ]
                );

                $province = Province::firstOrCreate([
                    'country_id' => $this->country->id,
                    'name' => $match['region'],
                    'zone_id' => $zone->id,
                ]);

                $district = District::firstOrCreate([
                    'name' => $match['municipality'],
                    'province_id' => $province->id,
                ]);

                $type = SettlementType::firstOrCreate([
                    'name' => $match['type'],
                    'short_name' => $match['type'],
                ]);

                if ( 
                    ($zone->short_name === 'ЦФО') && 
                       ( ($province->name === 'Московская область') || ($province->name === 'Москва') )
                ) {
                    $price_category = 1;
                } elseif ($zone->short_name === 'ЦФО') {
                    $price_category = 2;
                } elseif ($zone->short_name === 'СЗФО') {
                    $price_category = 3;
                } else {
                    $price_category = 4;
                }

                $Declinat = Declinat::where('name', $match['settlement'])->first();
                if ($Declinat) {
                    $needsUpdateSwitcher = false;

                    if (!$Declinat->genitive && !empty($settelment['PADEG_CHEGO'][0])) {
                        $Declinat->genitive = $settelment['PADEG_CHEGO'][0];
                        $needsUpdateSwitcher = true;
                    }

                    if (!$Declinat->locative && !empty($settelment['PADEG_GDE'][0])) {
                        $Declinat->locative = $settelment['PADEG_GDE'][0];
                        $needsUpdateSwitcher = true;
                    }

                    if ($needsUpdateSwitcher) {
                        $Declinat->save();
                    }
                } else {
                    $Declinat = Declinat::create([
                        'name'       => $match['settlement'],
                        'nominative' => $match['settlement'],
                        'genitive'   => $settelment['PADEG_CHEGO'][0] ?? null,
                        'locative'   => $settelment['PADEG_GDE'][0] ?? null,
                    ]);
                }

                $settlement = Settlement::firstOrCreate([
                    'district_id' => $district->id,
                    'settlement_type_id' => $type->id,
                    'name' => $match['settlement'],
                ], [
                    'price_category' => $price_category,
                    'Declinat_id' => $Declinat->id,
                    'ohrana_slug' => $settelment['SLUG'] ?? null,
                    'population' => $match['population'] ?? 0,
                    'latitude' => $match['latitude_dd'],
                    'longitude' => $match['longitude_dd'],
                ]);

                // Внутригородские округа
                foreach (explode(';', $settelment["CITY_DICTRICT"][0] ?? '') as $divisionName) {
                    if (!trim($divisionName)) continue;

                    SettlementDivision::firstOrCreate([
                        'settlement_id' => $settlement->id,
                        'name' => trim($divisionName),
                        'short_name' => trim($divisionName),
                    ]);
                }

                // Внутригородские районы
                foreach (explode(';', $settelment["CITY_REGION"][0] ?? '') as $sectorName) {
                    if (!trim($sectorName)) continue;

                    SettlementSector::firstOrCreate([
                        'name' => trim($sectorName),
                        'settlement_id' => $settlement->id,
                    ]);
                }

                ////// Баннер //////
                $bannerRelativePath = $settelment['BANNER'][0] ?? null;

                if ($bannerRelativePath) {
                    $bannerUrl = $this->sourceUrl . $bannerRelativePath;

                    try {
                        $response = Http::timeout(10)->get($bannerUrl);

                        if ($response->successful()) {
                            $binaryContent = $response->body();
                            $contentHash = md5($binaryContent); // используем хэш содержимого как ключ

                            // Проверка: уже прикреплён баннер с таким хэшем?
                            $alreadyExists = $settlement->media()
                                ->where('collection_name', 'banners')
                                ->where('custom_properties->hash', $contentHash)
                                ->exists();

                            if ($alreadyExists) {
                                $this->command->info("✅ Баннер с hash={$contentHash} уже прикреплён к {$settlement->name}, пропускаем");
                                continue;
                            }

                            $filename = pathinfo($bannerRelativePath, PATHINFO_BASENAME);
                            $mime = $response->header('Content-Type') ?? 'image/jpeg';

                            // Добавление напрямую из памяти
                            $settlement
                                ->addMediaFromString($binaryContent)
                                ->usingName($filename)
                                ->usingFileName($contentHash . '_' . $filename)
                                ->withCustomProperties(['hash' => $contentHash])
                                ->preservingOriginal()
                                ->toMediaCollection('banners');

                            $weight = number_format(strlen($binaryContent) / 1048576, 2);
                            $this->command->info("➕ Баннер прикреплён к {$settlement->name} ({$weight} MB) — {$filename}");
                        } else {
                            $this->command->warn("⛔ Не удалось загрузить баннер: {$bannerUrl}");
                        }
                    } catch (\Throwable $e) {
                        $this->command->warn("Ошибка загрузки баннера: " . $e->getMessage());
                    }
                }
            }

            $this->command->info('RussiaBigSettelments данные установлены');
        } catch (\Throwable $e) {
            $this->command->warn('File: ' . $e->getFile() . ' | Line#' . $e->getLine() . ' выброс: ' . $e->getMessage());
            exit;
        }
    }

    public function getRussiaBigSettelments()
    {
        $response = Http::accept('application/json')
            ->asForm()
            ->withOptions(['verify' => false])
            ->post($this->sourceUrl . '/ajax/api/regionsJson.php', [
                'laravel' => '***at',
                'reason' => 'goroda_rossii'
            ]);

        return $response->body();
    }
}
// php artisan db:seed --class=Database\\Seeders\\Pages\\GeoSeeder
