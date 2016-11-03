<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use Grids;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use GrahamCampbell\BootstrapCMS\Models\ModelInterface;
use Nayjest\Grids\Components\FiltersRow;

/**
 * Class GridService
 * 
 * Usage example.
 * 1. In your template render method add following:
 *  $grid = new GridService();
 *  $user = new User();
 *
 *  $gridComponent = $grid->generateGrid($user, ['first_name' => ['filter' => 'like'], 'last_name', 'email'], ['csv', 'exel', 'recordsPerPage', 'hider', 'refresher']);
 *  view('your_template',  compact('gridComponent'));
 *
 * 2. In template add following:
 *   {!! $gridComponent !!}
 *
 * @package GrahamCampbell\BootstrapCMS\Services
 */
class GridService
{
    protected $gridName;
    protected $pageSize;

    /**
     * Generate table
     *
     * @param \GrahamCampbell\BootstrapCMS\Models\ModelInterface $model
     * @param array $fields
     * @param array $components
     *
     * @return object
     */
    public function generateGrid(ModelInterface $model, $fields, $components = [])
    {
        $className = $model->getClassName();

        $config = (new GridConfig)
            ->setDataProvider(
                new EloquentDataProvider($className::query())
            )
            ->setName($this->getGridName())
            ->setPageSize($this->getPageSize());

        $config = $this->setColumns($fields, $config);

        $config = !$components ? $config : $this->setComponents($config, $components);

        $grid = new Grid($config);

        return $grid->render();
    }

    /**
     * Set columns into config.
     *
     * @param array $fields
     * @param \Nayjest\Grids\GridConfig $config
     *
     * @return \Nayjest\Grids\GridConfig
     */
    private function setColumns($fields, GridConfig $config)
    {
        $columns = [];

        foreach ($fields as $key => $field) {
            if (is_array($field)) {
                $columns[] = $this->addColumnWithFeatures($key, $field);
            } else {
                $columns[] = $this->addPlainColumn($field);
            }
        }

        $columns = array_merge([
            (new FieldConfig)
                ->setName('id')
                ->setLabel('ID')
                ->setSortable(true)
                ->setSorting(Grid::SORT_ASC)
        ], $columns);

        return $config->setColumns($columns);
    }

    /**
     * Add column without filters.
     *
     * @param string $field
     * @return FieldConfig
     */
    private function addPlainColumn($field)
    {
        return (new FieldConfig)
            ->setName($field)
            ->setLabel(ucfirst($this->snakeCaseConvertation($field)));
    }

    /**
     * Add column with filters.
     *
     * @param string $key
     * @param array $field
     *
     * @return FieldConfig
     */
    private function addColumnWithFeatures($key, $field)
    {
        return (new FieldConfig)
            ->setName($key)
            ->setLabel(array_get($field, 'label', ucfirst($key)))
            ->setSortable(array_get($field, 'sortable', 'false'))
            ->setSorting(array_get($field, 'sorting', null))
            ->setCallback(array_get($field, 'callback', null))
            ->addFilter(
                (new FilterConfig)
                    ->setOperator(array_get($field, 'filter', FilterConfig::OPERATOR_LIKE))
            );
    }

    /**
     * Get grid name
     *
     * @return string
     */
    public function getGridName()
    {
        return $this->gridName ?: 'grid';
    }

    /**
     * Set grid name
     *
     * @param string $name
     */
    public function setGridName($name)
    {
        $this->gridName = $name;
    }

    /**
     * Get grid name
     *
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize ?: 15;
    }

    /**
     * Set page size
     *
     * @param int
     */
    public function setPageSize($size)
    {
        $this->pageSize = $size;
    }

    /**
     * Check is array associative or not
     *
     * @param array $value
     * @return bool
     */
    public function isAssociative($value)
    {
        if (!is_array($value) || empty($value)) {
            return false;
        }

        $keys = array_keys($value);

        return array_keys($keys) !== $keys;
    }

    /**
     * Convert string in snake case into string devided with spaces.
     *
     * @param string $value
     * @return string
     */
    public function snakeCaseConvertation($value)
    {
        return implode(explode('_', $value), ' ');
    }

    /**
     * Set components method.
     *
     * @param GridConfig $config
     * @param array $components
     * @return GridConfig
     */
    public function setComponents(GridConfig $config, $components)
    {
        $componentsObjects = [];

        foreach ($components as $component) {
            $method = 'set' . ucfirst($component) . 'Component';

            if (method_exists($this, $method)) {
                $componentsObjects[] = $this->{$method}();
            }
        }

       return $config->setComponents([
       (new THead)
           ->setComponents([
               (new ColumnHeadersRow),
               (new FiltersRow),
               (new OneCellRow)
                   ->setRenderSection(RenderableRegistry::SECTION_END)
                   ->setComponents($componentsObjects)
                ]
           )]
        );
    }

    /**
     * Set exel component.
     *
     * @return ExcelExport
     */
    private function setExelComponent()
    {
        return new ExcelExport();
    }

    /**
     * Set csv component.
     *
     * @return CsvExport
     */
    private function setCsvComponent()
    {
        return (new CsvExport)
            ->setFileName('my_report' . date('Y-m-d'));
    }

    /**
     * Set component which provides refresh filtered data button.
     *
     * @return HtmlTag
     */
    private function setRefresherComponent()
    {
        return (new HtmlTag)
            ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filter')
            ->setTagName('button')
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setAttributes([
                'class' => 'btn btn-success btn-sm'
            ]);
    }

    /**
     * Set columns hider component
     *
     * @return ColumnsHider
     */
    private function setHiderComponent()
    {
        return new ColumnsHider;
    }

    /**
     * Set paginator component.
     *
     * @return RecordsPerPage
     */
    private function setRecordsPerPageComponent()
    {
        return new RecordsPerPage;
    }
}