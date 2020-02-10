<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
   use RefreshDatabase;

   public function test_an_author_can_be_created(){
       $this->withoutExceptionHandling();

       $response = $this->post('/author', [
             'name' => 'Author Name',
             'dob'  => '05/14/1988',
        ]);

        $author = Author::all();

        //$response->assertOk();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1988/14/05', $author->first()->dob->format('Y/d/m'));
   }
   public function test_a_new_author_is_automatically_added()
   {
       $this->withoutExceptionHandling();

       $this->post('/books', [
           'title'=> 'Cool Title',
           'author_id'=> 'Adrian',
       ]);
       $book = Book::first();
       $author = Author::first();

       $this->assertEquals($author->id, $book->author_id);
       $this->assertCount(1, Author::all());
   }
}
