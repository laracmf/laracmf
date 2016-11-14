<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Services\ConfigurationsService;

class ConfigurationServiceTest extends TestCase
{
    /**
     * @var array
     */
    protected $testData = [
        'keys' => [
            'APP_ENV',
            'APP_DEBUG',
            'APP_NAME'
        ],
        'values' => [
            'local',
            true,
            'TEST'
        ]
    ];

    /**
     * @name providerGetEnvironment
     * @return array
     */
    public function providerGetEnvironment()
    {
        return [
            'testGetEnvironment' => [
                'name' => 'vagrant',
                'assertMethod' => 'assertArrayHasKey',
                'expected' => 'APP_ENV'
            ],
            'testGetEnvironmentFailed' => [
                'name' => 'new',
                'assertMethod' => 'assertEquals',
                'expected' => false
            ]
        ];
    }

    /**
     * Configuration service instance.
     *
     * @var object
     */
    public $configurationService;

    public function setUp()
    {
        parent::setUp();

        config(['app.env_path' => 'config/env']);

        $this->configurationService = new ConfigurationsService();
    }

    /**
     * Test get environments list.
     */
    public function testGetEnvironmentsList()
    {
        $this->assertEquals([2 => 'testing', 3 => 'vagrant'], $this->configurationService->getEnvironmentsList());
    }

    /**
     * Test get environment data
     *
     * @dataProvider providerGetEnvironment
     *
     * @param $name
     * @param $assertMethod
     * @param $expected
     */
    public function testGetEnvironment($name, $assertMethod, $expected)
    {
        $this->{$assertMethod}($expected, $this->configurationService->getEnvironment($name));
    }

    /**
     * Test write data in new config file.
     */
    public function testWriteData()
    {
        $data = $this->testData;
        $data['name'] = 'test12345';

        $this->assertTrue(true, $this->configurationService->writeData($data));
    }

    /**
     * Test delete config file.
     */
    public function testDeleteConfig()
    {
        $this->assertEquals(true, $this->configurationService->deleteConfig('test12345'));

        $this->assertEquals([2 => 'testing', 3 => 'vagrant'], $this->configurationService->getEnvironmentsList());
    }

    /**
     * Test creation associations
     */
    public function testCreateAssociations()
    {
        $expected = ['APP_ENV=local', 'APP_DEBUG=1', 'APP_NAME=TEST'];

        $this->assertEquals(
            implode("\n", $expected),
            $this->configurationService->createAssociations($this->testData['keys'], $this->testData['values'])
        );
    }

    /**
     * Test get file name
     */
    public function testGetFileName()
    {
        $this->assertEquals('.env.testing', $this->configurationService->getFileName('testing'));
    }

    /**
     * Test file exists
     */
    public function testFileExists()
    {
        $this->assertTrue($this->configurationService->fileExists('testing'));
    }
}