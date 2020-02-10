<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
   use RefreshDatabase;
   public function test_a_book_can_be_added_to_the_library() {

       $this->withoutExceptionHandling();

       $response = $this->post('/books', $this->data());
       $book = Book::first();
    //    $response->assertOk();
       $this->assertCount(1, Book::all());
       $response->assertRedirect($book->path());
   }

   public function test_a_title_is_required() {

    $response = $this->post('/books', array_merge($this->data(), ['title'=>'']));
    $response->assertSessionHasErrors('title');
   }

   public function test_author_is_required()
   {
    $response = $this->post('/books', array_merge($this->data(), ['author_id'=>'']));
      $response->assertSessionHasErrors('author_id');
   }

   public function test_a_book_can_be_updated(){

        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

       $book = Book::first();
       $response = $this->patch($book->path(), [
        'title' => 'New Title',
        'author_id' => 'New Author',
       ]);
       $this->assertEquals('New Title', Book::first()->title);
       $this->assertEquals('New Author', Book::first()->author_id);
       $response->assertRedirect($book->fresh()->path());

   }
   public function test_a_book_can_be_deleted(){
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
   }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Adrian',
        ];
    }
}
