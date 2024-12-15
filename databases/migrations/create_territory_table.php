<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;

return new class extends Migration
{
    /**
     * Adds a column to the given table with a name specified by the $name parameter.
     * If the database driver is PostgreSQL or MySQL, a full-text column is added.
     * Otherwise, a string column is added.
     *
     * @param  Blueprint  $table  The table to add the column to.
     * @param  string  $name  The name of the column to be added.
     * @return Blueprint The modified table blueprint.
     */
    public function nameColumn(Blueprint &$table, string $name)
    {
        $connection = config('territory_id.connection', config('database.default'));
        $driverName = DB::connection($connection)->getDriverName();

        if ($driverName === 'pgsql' || $driverName === 'mysql') {
            $table->string($name)->fulltext();
        } else {
            $table->string($name);
        }

        return $table;
    }

    /**
     * Run the migrations to create the territory tables.
     *
     * This method creates four tables: provinces, regencies, districts, and villages.
     * Each table is created with its respective columns and primary keys. Foreign keys
     * are set up to enforce relationships between the tables.
     *
     * - The provinces table contains a primary key 'code' and a name column.
     * - The regencies table contains columns for province code, regency code, and name,
     *   with a foreign key referencing provinces.
     * - The districts table contains columns for province code, regency code, district code,
     *   and name, with a foreign key referencing regencies.
     * - The villages table contains columns for province code, regency code, district code,
     *   village code, name, and zip code, with a foreign key referencing districts.
     *
     * The schema connection is determined by the 'territory' configuration.
     */
    public function up()
    {
        $connection = config('territory_id.connection', config('database.default'));
        $schema = Schema::connection($connection);

        $this->down();

        if (! $schema->hasTable((new Province)->getTable())) {
            $schema->create((new Province)->getTable(), function (Blueprint $table){
                $table->char('province_code', 2)
                    ->primary();

                $this->nameColumn($table, 'province_name');
            });
        }

        if (! $schema->hasTable((new Regency)->getTable())) {
            $schema->create((new Regency)->getTable(), callback: function (Blueprint $table) {
                $table->char('province_code', 2);
                $table->char('regency_code', 2);
                $this->nameColumn($table, 'regency_name');

                $table->primary([
                    'province_code',
                    'regency_code',
                ]);

                $table->foreign('province_code')
                    ->references('province_code')
                    ->on((new Province)->getTable())
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }

        if (! $schema->hasTable((new District)->getTable())) {
            $schema->create((new District)->getTable(), callback: function (Blueprint $table) {
                $table->char('province_code', 2);
                $table->char('regency_code', 2);
                $table->char('district_code', 2);
                $this->nameColumn($table, 'district_name');

                $table->primary([
                    'province_code',
                    'regency_code',
                    'district_code',
                ]);

                $table->foreign([
                    'province_code',
                    'regency_code',
                ])
                    ->references([
                        'province_code',
                        'regency_code',
                    ])
                    ->on((new Regency)->getTable())
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }

        if (! $schema->hasTable((new Village)->getTable())) {
            $schema->create((new Village)->getTable(), callback: function (Blueprint $table) {
                $table->char('province_code', 2);
                $table->char('regency_code', 2);
                $table->char('district_code', 2);
                $table->char('village_code', 4);
                $this->nameColumn($table, 'village_name');
                $table->char('zip_code', 5)
                    ->nullable()
                    ->index();

                $table->primary(columns: [
                    'province_code',
                    'regency_code',
                    'district_code',
                    'village_code',
                ]);

                $table->foreign([
                    'province_code',
                    'regency_code',
                    'district_code',
                ])
                    ->references([
                        'province_code',
                        'regency_code',
                        'district_code',
                    ])
                    ->on((new District)->getTable())
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * Drops the tables created by the up() method in reverse order.
     */
    public function down()
    {
        $connection = config('territory_id.connection', config('database.default'));
        $schema = Schema::connection($connection);

        $schema->dropIfExists((new Village)->getTable());
        $schema->dropIfExists((new District)->getTable());
        $schema->dropIfExists((new Regency)->getTable());
        $schema->dropIfExists((new Province)->getTable());
    }
};
