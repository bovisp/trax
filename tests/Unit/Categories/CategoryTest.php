<?php

namespace Tests\Unit\Categories;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    public function a_category_can_have_children()
    {
    	$parentCategory = factory(Category::class)->create();

    	$childCategory = factory(Category::class)->create([
    		'parent_id' => $parentCategory->id
    	]);

    	$this->assertInstanceOf(Category::class, $parentCategory->children->first());
    }

    /** @test */
    public function it_is_orderable_by_a_numbered_order()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $anotherCategory = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->assertEquals($anotherCategory->name, Category::ordered()->first()->name);
    }
}
