<?php

namespace Tests\Feature\Categories;

use App\Category;
use Tests\TestCase;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateCategoryOrderTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
	public function guests_cannot_update_the_order_of_categories()
	{		
		$this->json('PUT', 'api/categories/edit/order')
    		->assertStatus(401);
	}

	/** @test */
	public function only_administrators_can_update_the_order_of_categories()
	{
		$user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

    	$this->be($user);

    	$this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', [])
    		->assertStatus(403);
	} 

	/** @test */
	public function administrators_can_update_the_order_of_categories()
	{
		$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$categoryOne = factory(Category::class)->create([
    		'order' => 1
    	]);

    	$categoryTwo = factory(Category::class)->create([
    		'order' => 2
    	]);

    	$attributes = [
    		[ 'id' => $categoryOne->id, 'order' => 2 ],
    		[ 'id' => $categoryTwo->id, 'order' => 1 ]
    	];

    	$this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', $attributes);

    	$this->assertDatabaseHas('categories', [
    		'id' => $categoryOne->id,
    		'order' => 2
    	]);

    	$this->assertDatabaseHas('categories', [
    		'id' => $categoryTwo->id,
    		'order' => 1
    	]);
	} 

    /** @test */
    public function it_requires_an_id()
    {
        $this->withExceptionHandling();

        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $categoryOne = factory(Category::class)->create([
            'order' => 1
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 2
        ]);

         $attributes = [
            [ 'order' => 2 ],
            [ 'order' => 1 ]
        ];

        $response = $this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', $attributes)
            ->assertJsonValidationErrors(['0.id']);
    }

    /** @test */
    public function it_requires_a_valid_id()
    {
        $this->withExceptionHandling();

        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $categoryOne = factory(Category::class)->create([
            'order' => 1
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 2
        ]);

         $attributes = [
            [ 'id' => 'nope', 'order' => 2 ],
            [ 'id' => 'nope', 'order' => 1 ]
        ];

        $response = $this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', $attributes)
            ->assertJsonValidationErrors(['0.id']);
    }

    /** @test */
    public function it_requires_the_order()
    {
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $categoryOne = factory(Category::class)->create([
            'order' => 1
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 2
        ]);

         $attributes = [
            [ 'id' => 1 ],
            [ 'id' => 2 ]
        ];

        $response = $this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', $attributes)
            ->assertJsonValidationErrors(['0.order']);
    }

    /** @test */
    public function it_requires_the_order_to_be_an_integer()
    {
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $categoryOne = factory(Category::class)->create([
            'order' => 1
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 2
        ]);

         $attributes = [
            [ 'id' => 1, 'order' => 'nope' ],
            [ 'id' => 2, 'order' => 'nope' ]
        ];

        $response = $this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', $attributes)
            ->assertJsonValidationErrors(['0.order']);
    }

    /** @test */
    public function it_requires_the_order_to_be_unique()
    {
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $categoryOne = factory(Category::class)->create([
            'order' => 1
        ]);

        $categoryTwo = factory(Category::class)->create([
            'order' => 2
        ]);

         $attributes = [
            [ 'id' => 1, 'order' => 1 ],
            [ 'id' => 2, 'order' => 1 ]
        ];

        $response = $this->jsonAs(auth()->user(), 'PUT', 'api/categories/edit/order', $attributes)
            ->assertJsonValidationErrors(['0.order']);
    }
}
