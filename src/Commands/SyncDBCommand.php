<?php

namespace Vermaysha\Territory\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;

class SyncDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'territory:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize database with the latest data from the github';

    /**
     * The URL of the CSV file for provinces
     *
     * @var string
     */
    protected $provincesUrl = 'https://raw.githubusercontent.com/vermaysha/database-wilayah-indonesia/refs/heads/master/db/data-provinsi.csv';

    /**
     * The URL of the CSV file for regencies
     *
     * @var string
     */
    protected $regenciesUrl = 'https://raw.githubusercontent.com/vermaysha/database-wilayah-indonesia/refs/heads/master/db/data-kabupaten.csv';

    /**
     * The URL of the CSV file for districts
     *
     * @var string
     */
    protected $districtsUrl = 'https://raw.githubusercontent.com/vermaysha/database-wilayah-indonesia/refs/heads/master/db/data-kecamatan.csv';

    /**
     * The URL of the CSV file for villages
     *
     * @var string
     */
    protected $villagesUrl = 'https://raw.githubusercontent.com/vermaysha/database-wilayah-indonesia/refs/heads/master/db/data-kelurahan.csv';

    /**
     * Execute the console command.
     *
     * This command will sync the database with the latest data from the github.
     * Before running this command, make sure you have already set the correct
     * connection name in the config file.
     *
     * If you are using SQLite as your database driver, this command will first
     * disable the foreign key check before running the sync process.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Syncronize database with the latest data from the github');
        $this->newLine();
        $this->info('Syncronizing Territory...');

        $this->syncProvinces();
        $this->syncRegencies();
        $this->syncDistricts();
        $this->syncVillages();
    }

    /**
     * Sync provinces from the given URL to the database.
     *
     * @return void
     */
    protected function syncProvinces()
    {
        $this->info('Syncronizing provinces...');

        $data = $this->fetchGithubData($this->provincesUrl);
        $this->info('Found '.$data->count().' provinces');

        try {
            $this->db()->beginTransaction();
            $provinces = $data->map(function ($item) {
                return [
                    'province_code' => $item['kode_provinsi'],
                    'province_name' => $item['nama_provinsi'],
                ];
            })->toArray();

            $this->db()
                ->table((new Province())->getTable())
                ->upsert(
                    $provinces,
                    [
                        'province_code',
                    ],
                    [
                        'province_name',
                    ]
                );

            $this->db()->commit();

            $this->info('Provinces synced successfully');
        } catch (\Throwable $th) {
            $this->db()->rollBack();
            $this->error('Failed to sync provinces: '.$th->getMessage());
        }
    }

    /**
     * Synchronizes regencies data from a remote source to the local database.
     *
     * This function fetches regencies data from a specified GitHub URL, processes
     * the data, and updates the local database with the regencies information.
     * It utilizes a transaction to ensure data integrity and performs an upsert
     * operation to insert or update records as necessary. In the event of an error,
     * the transaction is rolled back and an error message is logged.
     *
     * @return void
     */
    protected function syncRegencies()
    {
        $this->info('Syncronizing regencies...');

        $data = $this->fetchGithubData($this->regenciesUrl);

        $this->info('Found '.$data->count().' regencies');

        try {
            $this->db()->beginTransaction();
            $regencies = $data->map(function ($item) {
                return [
                    'province_code' => $item['kode_provinsi'],
                    'regency_code' => $item['kode_kabupaten'],
                    'regency_name' => $item['nama_kabupaten'],
                ];
            })->chunk(100)->toArray();
            foreach ($regencies as $items) {
                $this->db()
                    ->table((new Regency())->getTable())
                    ->upsert(
                        $items,
                        [
                            'province_code',
                            'regency_code',
                        ],
                        [
                            'regency_name',
                        ]
                    );
            }

            $this->db()->commit();

            $this->info('Regencies synced successfully');
        } catch (\Throwable $th) {
            $this->db()->rollBack();
            $this->error('Failed to sync regencies: '.$th->getMessage());
        }
    }

    /**
     * Sync districts from the given URL to the database.
     *
     * @return void
     */
    protected function syncDistricts()
    {
        $this->info('Syncronizing districts...');

        $data = $this->fetchGithubData($this->districtsUrl);

        $this->info('Found '.$data->count().' districts');

        try {
            $this->db()->beginTransaction();
            $districts = $data->map(function ($item) {
                return [
                    'province_code' => $item['kode_provinsi'],
                    'regency_code' => $item['kode_kabupaten'],
                    'district_code' => $item['kode_kecamatan'],
                    'district_name' => $item['nama_kecamatan'],
                ];
            })->chunk(100)->toArray();
            foreach ($districts as $items) {
                $this->db()
                    ->table((new District)->getTable())
                    ->upsert(
                        $items,
                        [
                            'province_code',
                            'regency_code',
                            'district_code',
                        ],
                        [
                            'district_name',
                        ]
                    );
            }

            $this->db()->commit();

            $this->info('Districts synced successfully');
        } catch (\Throwable $th) {
            $this->db()->rollBack();
            $this->error('Failed to sync districts: '.$th->getMessage());
        }
    }

    /**
     * Synchronizes villages data from a remote source to the local database.
     *
     * This function fetches villages data from a specified GitHub URL, processes
     * the data, and updates the local database with the villages information.
     * It utilizes a transaction to ensure data integrity and performs an upsert
     * operation to insert or update records as necessary. In the event of an error,
     * the transaction is rolled back and an error message is logged.
     *
     * @return void
     */
    protected function syncVillages()
    {
        $this->info('Syncronizing villages...');

        $data = $this->fetchGithubData($this->villagesUrl);
        $this->info('Found '.$data->count().' villages');

        try {
            $this->db()->beginTransaction();
            $villages = $data->map(function ($item) {
                return [
                    'province_code' => $item['kode_provinsi'],
                    'regency_code' => $item['kode_kabupaten'],
                    'district_code' => $item['kode_kecamatan'],
                    'village_code' => $item['kode_kelurahan'],
                    'village_name' => $item['nama_kelurahan'],
                    'zip_code' => $item['kode_pos'],
                ];
            })->chunk(1000)->toArray();
            foreach ($villages as $items) {
                $this->db()
                    ->table((new Village())->getTable())
                    ->upsert(
                        $items,
                        [
                            'province_code',
                            'regency_code',
                            'district_code',
                            'village_code',
                        ],
                        [
                            'village_name',
                            'zip_code',
                        ]
                    );
            }

            $this->db()->commit();

            $this->info('Villages synced successfully');
        } catch (\Throwable $th) {
            $this->db()->rollBack();
            $this->error('Failed to sync villages: '.$th->getMessage());
        }
    }

    /**
     * Get the database connection specified in the configuration.
     *
     * @return \Illuminate\Database\Connection The database connection instance.
     */
    protected function db()
    {
        return DB::connection(config('territory.connection'));
    }

    /**
     * Fetch data from a GitHub repository CSV file.
     *
     * @param  string  $url  URL of the CSV file on GitHub.
     * @return \Illuminate\Support\Collection The collection of data from the CSV file.
     */
    protected function fetchGithubData(string $url)
    {
        $ch = @curl_init();

        @curl_setopt($ch, CURLOPT_URL, $url);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = @curl_exec($ch);

        if (curl_errno($ch)) {
            $this->error('cURL error: '.curl_error($ch));
            @curl_close($ch);

            return collect([]);
        }

        @curl_close($ch);

        return $this->parseCSV($response);
    }

    /**
     * Parses CSV data into a collection of associative arrays.
     *
     * This function splits the provided CSV data by lines, extracts the header
     * from the first line, and then maps each subsequent line into an associative
     * array using the headers. The result is a collection of these arrays.
     *
     * @param  string  $data  The CSV data to parse.
     * @return \Illuminate\Support\Collection A collection of associative arrays
     *                                        representing the CSV data.
     */
    protected function parseCSV(string $data)
    {
        $lines = explode("\n", $data);
        $result = collect();

        $headers = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            $data = str_getcsv($line);
            $row = array_combine($headers, $data);

            $result->push($row);
        }

        return $result;
    }
}
