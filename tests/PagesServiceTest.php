<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Models\Page;
use GrahamCampbell\BootstrapCMS\Services\GridService;
use GrahamCampbell\BootstrapCMS\Services\PagesService;

class PagesServiceTest extends TestCase
{
    /**
     * Pages service instance.
     *
     * @var object
     */
    public $pagesService;

    public function setUp()
    {
        parent::setUp();

        $gridService = new GridService();

        $this->pagesService = new PagesService($gridService);
    }

    /**
     * Test get page categories.
     */
    public function testGetPageCategories()
    {
        $this->assertEquals(1, count($this->pagesService->getPageCategories(Page::find(1))));
    }

    /**
     * Test delete category page relation.
     */
    public function testDeleteCategoryPages()
    {
        $page = Page::find(2);

        $this->pagesService->deletePageCategories($page);
        $this->assertEquals(0, count($this->pagesService->getPageCategories($page)));
    }

    /**
     * Test create category page relation.
     */
    public function testSaveCategoryPages()
    {
        $page = Page::find(2);

        $this->pagesService->savePageCategories($page, [1, 2]);
        $this->assertEquals(2, count($this->pagesService->getPageCategories($page)));
    }
}
