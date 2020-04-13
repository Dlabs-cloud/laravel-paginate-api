<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 13/04/2020
 * Time: 12:19 PM
 */

namespace Dlabs\PaginateApi\Test;


use Carbon\Carbon;
use Dlabs\PaginateApi\PaginateApiServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::create('1955', '1', '1', '1', '1', '1'));

        $this->setUpDatabase($this->app);

        $this->setUpRoutes($this->app);
    }


    protected function getPackageProviders($app)
    {
        return [
            PaginateApiServiceProvider::class
        ];
    }


    protected function getEnvironmentSetUp($app)
    {
        $config = $app['config'];
        $config->set('database.default', 'sqlite');
        $config->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $config->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');
    }

    private function setUpDatabase(\Illuminate\Foundation\Application $app)
    {
        $app['db']
            ->connection()
            ->getSchemaBuilder()
            ->create('test_models', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->rememberToken();
                $table->timestamps();
            });
    }

    private function setUpRoutes(\Illuminate\Foundation\Application $app)
    {
        Route::any('/', function () {
            return TestModel::paginateApi();
        });
    }


    protected function mockTestModel($count = 1)
    {
        foreach (range(0, $count) as $index) {
            TestModel::create(['name' => "testModel{$index}"]);
        }


    }
}