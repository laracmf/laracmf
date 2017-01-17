<?php

namespace App\Tests;

use App\Services\ConfigurationsService;

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
     * Configuration service instance.
     *
     * @var object
     */
    public $configurationService;

    public function setUp()
    {
        parent::setUp();

        config(['app.env_path' => '']);

        $this->configurationService = new ConfigurationsService();
    }

    /**
     * Test get environment data
     */
    public function testGetEnvironment()
    {
        $this->assertArrayHasKey('APP_ENV', $this->configurationService->getEnvironment());
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
     * Test file exists
     */
    public function testFileExists()
    {
        $this->assertTrue($this->configurationService->fileExists('.env'));
    }
}