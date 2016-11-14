<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Models\Category;
use GrahamCampbell\BootstrapCMS\Services\CategoriesService;
use Mockery;

class CategoryControllerTest extends TestCase
{
    /**
     * @name providerShowCreateForm
     * @return array
     */
    public function providerShowCreateForm()
    {
        return [
            'testShowCreateForm' => [
                'id' => 1,
                'expected' => 'Category Name',
            ],
            'testShowCreateFormFailed' => [
                'id' => 2,
                'expected' => 'Redirecting to',
            ]
        ];
    }

    /**
     * @name providerEditCategoryForm
     * @return array
     */
    public function providerEditCategoryForm()
    {
        return [
            'testEditCategoryForm' => [
                'id' => 0,
                'expected' => '<input name="name" id="name" value="test" type="text"',
            ],
            'testEditCategoryFormFailed' => [
                'id' => 2,
                'expected' => 'Redirecting to',
            ]
        ];
    }

    /**
     * @name providerCreateCategory
     * @return array
     */
    public function providerCreateCategory()
    {
        return [
            'testCreateCategory' => [
                'data' => [
                    'name' => 'test',
                    'pages' => [1,2,3]
                ],
                'expected' => 'Redirecting to',
                'assertMethod' => 'assertNotEmpty'
            ],
            'testCreateCategoryFailed' => [
                'data' => [
                    'name' => 'test',
                    'pages' => 1
                ],
                'expected' => 'The pages must be an array.',
                'assertMethod' => 'assertEmpty'
            ]
        ];
    }

    /**
     * @name providerEditCategory
     * @return array
     */
    public function providerEditCategory()
    {
        return [
            'testEditCategory' => [
                'data' => [
                    'name' => 'test1'
                ],
                'id' => 0,
                'expected' => 'Redirecting to'
            ],
            'testEditCategoryFailed' => [
                'data' => [
                    'name' => 'test'
                ],
                'id' => 100,
                'expected' => 'The name has already been taken.'
            ]
        ];
    }

    /**
     * Test show create form for category entity.
     *
     * @dataProvider providerShowCreateForm
     *
     * @param $id
     * @param $expected
     */
    public function testShowCreateForm($id, $expected)
    {
        $this->authenticateUser($id);

        $this->json('GET', 'category', [], [])->see($expected);
    }

    /**
     * Test show categories view.
     */
    public function testShowCategories()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'categories', [], [])->see('<i class="fa fa-folder"></i> New Category</a>');
    }

    /**
     * Test show edit category form.
     *
     * @dataProvider providerEditCategoryForm
     *
     * @param $id
     * @param $expected
     */
    public function testEditCategoryForm($id, $expected)
    {
        $this->authenticateUser(1);

        $category = new Category();
        $category->name = 'test';
        $category->save();

        if (!$id) {
            $id = $category->id;
        }

        $this->json('GET', 'category/' . $id, [], [])->see($expected);
    }

    /**
     * Test category creation.
     *
     * @dataProvider providerCreateCategory
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @param $data
     * @param $expected
     * @param $assertMethod
     */
    public function testCreateCategory($data, $expected, $assertMethod)
    {
        $this->authenticateUser(1);

        $categoryService = Mockery::mock('overload:' . CategoriesService::class);
        $categoryService->shouldReceive('saveCategoryPages')->once();

        $this->json('POST', 'category', $data, [])->see($expected);

        $category = Category::where('name', '=', 'test')->first();

        $this->{$assertMethod}($category);
    }


    /**
     * Test delete category.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDeleteCategory()
    {
        $this->authenticateUser(1);

        $categoryService = Mockery::mock('overload:' . CategoriesService::class);
        $categoryService->shouldReceive('saveCategoryPages')->once();
        $categoryService->shouldReceive('deleteCategoryPages')->once();

        $category = new Category();
        $category->name = 'test';
        $category->save();

        $this->assertNotEmpty(Category::find($category->id));

        $this->json('DELETE', 'category', ['id' => $category->id], []);

        $this->assertEmpty(Category::find($category->id));
    }

    /**
     * Test category editing.
     *
     * @dataProvider providerEditCategory
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @param $data
     * @param $id
     * @param $expected
     */
    public function testEditCategory($data, $id, $expected)
    {
        $this->authenticateUser(1);

        $categoryService = Mockery::mock('overload:' . CategoriesService::class);
        $categoryService->shouldReceive('saveCategoryPages')->once();
        $categoryService->shouldReceive('deleteCategoryPages')->once();

        $category = new Category();
        $category->name = 'test';
        $category->save();

        if (!$id) {
            $id = $category->id;
        }

        $this->json('POST', 'category/' . $id, $data, [])->see($expected);
    }

    /**
     * Test search category using query string.
     */
    public function testSearchCategory()
    {
        $this->authenticateUser(1);

        $category = new Category();
        $category->name = 'test';
        $category->save();

        $this->json('GET', 'search/categories', ['query' => 'te'], [])
            ->seeJsonEquals([['id' => $category->id,'text' => 'test']]);
    }
}
