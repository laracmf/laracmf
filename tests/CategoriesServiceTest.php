<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Models\Category;
use GrahamCampbell\BootstrapCMS\Services\CategoriesService;

class CategoriesServiceTest extends TestCase
{
    /**
     * Categories service instance.
     *
     * @var object
     */
    public $categoriesService;

    public function setUp()
    {
        parent::setUp();

        $this->categoriesService = new CategoriesService();
    }

    /**
     * Test get category pages.
     */
    public function testGetCategoryPages()
    {
        $this->assertEquals(2, count($this->categoriesService->getCategoryPages(Category::find(1))));
    }

    /**
     * Test delete category page relation.
     */
    public function testDeleteCategoryPages()
    {
        $category = Category::find(2);

        $this->categoriesService->deleteCategoryPages($category);
        $this->assertEquals(0, count($this->categoriesService->getCategoryPages($category)));
    }

    /**
     * Test create category page relation.
     */
    public function testSaveCategoryPages()
    {
        $category = Category::find(2);

        $this->categoriesService->saveCategoryPages($category, [1, 2]);
        $this->assertEquals(2, count($this->categoriesService->getCategoryPages($category)));
    }
}
