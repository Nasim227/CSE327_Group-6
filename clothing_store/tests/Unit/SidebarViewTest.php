<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * Class SidebarViewTest
 *
 * Tests the behaviour of the sidebar Blade view used for filtering products.
 *
 * We test that:
 * - All brands and categories passed to the view are displayed.
 * - Selected brands and categories are marked as "checked".
 * - Min and max price values appear in the correct inputs.
 */
class SidebarViewTest extends TestCase
{
    /**
     * The name of the sidebar view.
     *
     * Change 'search.sidebar' if your view path is different
     * (e.g. 'products.sidebar').
     */
    protected string $viewName = 'products.products_sidebar';

    /** @test */
    public function sidebar_shows_all_brands_and_categories()
    {
        $view = $this->view($this->viewName, [
            'brands'             => ['Aarong', 'Yellow'],
            'categories'         => [1, 2, 3],
            'selectedBrands'     => [],
            'selectedCategories' => [],
            'minPrice'           => null,
            'maxPrice'           => null,
        ]);

        // Check brands appear in the HTML
        $view->assertSee('Aarong', false);
        $view->assertSee('Yellow', false);

        // Check categories are rendered (we assume you print the category IDs)
        // e.g. "Category 1" or just "1" – adjust this text to match your HTML.
        $view->assertSee('1', false);
        $view->assertSee('2', false);
        $view->assertSee('3', false);
    }

    /** @test */
    public function sidebar_marks_selected_brand_as_checked()
    {
        $view = $this->view($this->viewName, [
            'brands'             => ['Aarong', 'Yellow'],
            'categories'         => [1, 2],
            'selectedBrands'     => ['Yellow'], // user selected "Yellow"
            'selectedCategories' => [],
            'minPrice'           => null,
            'maxPrice'           => null,
        ]);

        // We expect an input like:
        // <input type="checkbox" name="brands[]" value="Yellow" checked>
        $view->assertSee('name="brands[]"', false);
        $view->assertSee('value="Yellow"', false);
        $view->assertSee('checked', false);
    }

    /** @test */
    public function sidebar_marks_selected_category_as_checked()
    {
        $view = $this->view($this->viewName, [
            'brands'             => ['Aarong'],
            'categories'         => [1, 2, 3],
            'selectedBrands'     => [],
            'selectedCategories' => [2, 3], // user selected categories 2 and 3
            'minPrice'           => null,
            'maxPrice'           => null,
        ]);

        // We expect something like:
        // <input type="checkbox" name="categories[]" value="2" checked>
        $view->assertSee('name="categories[]"', false);
        $view->assertSee('value="2"', false);
        $view->assertSee('value="3"', false);
        $view->assertSee('checked', false);
    }

    /** @test */
    public function sidebar_shows_min_and_max_price_values()
    {
        $view = $this->view($this->viewName, [
            'brands'             => ['Aarong'],
            'categories'         => [1],
            'selectedBrands'     => [],
            'selectedCategories' => [],
            'minPrice'           => 500,
            'maxPrice'           => 2500,
        ]);

        // We expect inputs like:
        // <input type="number" name="min_price" value="500">
        // <input type="number" name="max_price" value="2500">
        $view->assertSee('name="min_price"', false);
        $view->assertSee('value="500"', false);

        $view->assertSee('name="max_price"', false);
        $view->assertSee('value="2500"', false);
    }
}
