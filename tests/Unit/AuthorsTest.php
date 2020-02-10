<?php

namespace Tests\Unit;

use App\Author;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_only_name_is_required_to_create_an_author()
    {
        Author::firstOrcreate([
            'name'=> 'John Doe',
        ]);
        $this->assertCount(1, Author::all());
    }
}
