<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Models\User;
use GrahamCampbell\BootstrapCMS\Services\GridService;

class GridServiceTest extends TestCase
{
    /**
     * @name providerGenerateGrid
     * @return array
     */
    public function providerGenerateGrid()
    {
        return [
            'testGenerateGrid' => [
                'fields' => ['email', 'first_name'],
                'components' => [],
                'expected' => '<th class="column-email">Email</th><th class="column-first_name">First name</th>',
                'message' => 'Assert that grid generated with declared fields.'
            ],
            'testGenerateGridCase2' => [
                'fields' => ['first_name' => ['filter' => 'like'], 'last_name', 'email'],
                'components' => [],
                'expected' => 'name="grid[filters][first_name-like]"',
                'message' => 'Expected that filter column code will present in view.'
            ],
            'testGenerateGridCase3' => [
                'fields' => ['last_name', 'email'],
                'components' => ['csv'],
                'expected' => 'CSV Export',
                'message' => 'Expected existence csv component on page.'
            ],
            'testGenerateGridCase4' => [
                'fields' => ['last_name', 'email'],
                'components' => 'dddddddd',
                'expected' => '<td class="column-last_name">User</td><td class="column-email">',
                'message' => 'Expected that template will rendered without errors.'
            ],
            'testGenerateGridCase5' => [
                'fields' => ['last_name', 'email'],
                'components' => ['exel'],
                'expected' => 'Excel Export',
                'message' => 'Expected existence exel component on page.'
            ],
            'testGenerateGridCase7' => [
                'fields' => ['last_name', 'email'],
                'components' => ['hider'],
                'expected' => 'ColumnHider.prototype.updateColumnVisibility',
                'message' => 'Expected existence hider component on page.'
            ],
            'testGenerateGridCase8' => [
                'fields' => ['last_name', 'email'],
                'components' => ['refresher'],
                'expected' => '<span class="glyphicon glyphicon-refresh"></span>',
                'message' => 'Expected existence refresher component on page.'
            ]
        ];
    }

    /**
     * Grid service instance.
     *
     * @var object
     */
    public $gridService;

    public function setUp()
    {
        parent::setUp();

        $this->gridService = new GridService();
    }

    /**
     * Test generate grid.
     *
     * @dataProvider providerGenerateGrid
     *
     * @param $fields
     * @param $components
     * @param $expected
     * @param $message
     */
    public function testGenerateGrid($fields, $components, $expected, $message)
    {
        $this->assertContains(
            $expected,
            $this->gridService->generateGrid(new User(), $fields, $components),
            $message
        );
    }
}
