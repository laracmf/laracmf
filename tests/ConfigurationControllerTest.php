<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Services\ConfigurationsService;
use Mockery;

class ConfigurationControllerTest extends TestCase
{
    /**
     * @name providerCreateEnvironment
     * @return array
     */
    public function providerCreateEnvironment()
    {
        return [
            'testCreateEnvironment' => [
                'data' => [
                    'name' => 'new_env',
                    'keys' => ['APP_ENV'],
                    'values' => ['local']
                ],
                'expected' => 'environments?environments%5B0%5D=vagrant&amp;environments%5B1%5D=testing',
            ],
            'testCreateEnvironmentFailed' => [
                'data' => [
                    'name' => 'vagrant',
                    'keys' => '',
                    'values' => ''
                ],
                'expected' => 'Config with such name already exists!',
            ]
        ];
    }

    /**
     * @name providerEditEnvironment
     * @return array
     */
    public function providerEditEnvironment()
    {
        return [
            'testEditEnvironment' => [
                'data' => [
                    'name' => 'new_env',
                    'keys' => ['APP_ENV'],
                    'values' => ['local']
                ],
                'name' => 'testing',
                'expected' => 'environments?environments%5B0%5D=vagrant&amp;environments%5B1%5D=testing',
            ],
            'testEditEnvironmentFailed' => [
                'data' => [
                    'name' => 'vagrant',
                    'keys' => '',
                    'values' => ''
                ],
                'name' => 'testing',
                'expected' => 'Config with such name already exists!',
            ]
        ];
    }

    /**
     * Test show environments.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testShowEnvironments()
    {
        $this->authenticateUser(1);

        $configurationsService = Mockery::mock('overload:' . ConfigurationsService::class);
        $configurationsService->shouldReceive('getEnvironmentsList')->once()->andReturn(['vagrant', 'testing']);

        $this->json('GET', 'environments', [], [])->see('/environment/vagrant');
    }

    /**
     * Test show edit environment config form.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testShowEditForm()
    {
        $this->authenticateUser(1);

        $configurationsService = Mockery::mock('overload:' . ConfigurationsService::class);
        $configurationsService->shouldReceive('getEnvironment')->once()->andReturn([
            'APP_ENV' => 'local',
            'APP_DEBUG' => 'true'
        ]);

        $this->json('GET', 'environment/vagrant', [], [])
            ->see('<input name="keys[]" value="APP_ENV" type="text" class="form-control">');
    }

    /**
     * Test show create environment config form.
     */
    public function testShowCreateForm()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'environment', [], [])->see('<i class="fa fa-plus"></i> Add New Pair</button>');
    }

    /**
     * Test create environment.
     *
     * @dataProvider providerCreateEnvironment
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @param $data
     * @param $expected
     */
    public function testCreateEnvironment($data, $expected)
    {
        $this->authenticateUser(1);

        $configurationsService = Mockery::mock('overload:' . ConfigurationsService::class);
        $configurationsService->shouldReceive('getEnvironmentsList')->once()->andReturn(['vagrant', 'testing']);
        $configurationsService->shouldReceive('writeData')->once()->andReturn(true);

        $this->json('POST', 'environment', $data, [])->see($expected);
    }

    /**
     * Test edit environment.
     *
     * @dataProvider providerEditEnvironment
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @param $data
     * @param $name
     * @param $expected
     */
    public function testEditEnvironment($data, $name, $expected)
    {
        $this->authenticateUser(1);

        $configurationsService = Mockery::mock('overload:' . ConfigurationsService::class);
        $configurationsService->shouldReceive('getEnvironmentsList')->once()->andReturn(['vagrant', 'testing']);
        $configurationsService->shouldReceive('writeData')->once()->andReturn(true);

        $this->json('PUT', 'environment/' . $name, $data, [])->see($expected);
    }

    /**
     * Test delete environment.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDeleteEnvironment()
    {
        $this->authenticateUser(1);

        $configurationsService = Mockery::mock('overload:' . ConfigurationsService::class);
        $configurationsService->shouldReceive('deleteConfig')->once()->andReturn(true);

        $this->json('DELETE', 'environment/testing', [], [])->seeStatusCode(200);
    }
}
