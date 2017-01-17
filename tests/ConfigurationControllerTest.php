<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Services\ConfigurationsService;
use Mockery;

class ConfigurationControllerTest extends TestCase
{
    /**
     * @name providerEditEnvironment
     * @return array
     */
    public function providerEditEnvironment()
    {
        return [
            'testEditEnvironment' => [
                'data' => [
                    'keys' => ['APP_ENV'],
                    'values' => ['local']
                ],
                'expected' => 'Redirecting to',
            ],
            'testEditEnvironmentFailed' => [
                'data' => [
                    'keys' => '',
                    'values' => ''
                ],
                'expected' => 'The values field is required.',
            ]
        ];
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
     * @param $expected
     */
    public function testEditEnvironment($data, $expected)
    {
        $this->authenticateUser(1);

        $configurationsService = Mockery::mock('overload:' . ConfigurationsService::class);
        $configurationsService->shouldReceive('writeData')->once()->andReturn(true);

        $this->json('PUT', 'environment', $data, [])->see($expected);
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

        $this->json('GET', 'environment', [], [])
            ->see('<input name="keys[]" value="APP_ENV" type="text" class="form-control">');
    }
}

