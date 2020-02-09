<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
   use RefreshDatabase;
   public function test_a_book_can_be_added_to_the_library() {

       $this->withoutExceptionHandling();

       $response = $this->post('/books', [
         'title' => 'Cool Book Title',
         'author' => 'Adrian',
       ]);
       $book = Book::first();
    //    $response->assertOk();
       $this->assertCount(1, Book::all());
       $response->assertRedirect($book->path());
   }

   public function test_a_title_is_required() {

    $response = $this->post('/books', [
      'title' => '',
      'author' => 'Adrian',
    ]);
    $response->assertSessionHasErrors('title');
   }

   public function test_author_is_required()
   {
    $response = $this->post('/books', [
        'title' => 'Cool Title',
        'author' => '',
      ]);
      $response->assertSessionHasErrors('author');
   }

   public function test_a_book_can_be_updated(){

        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Adrian',
        ]);

       $book = Book::first();
       $response = $this->patch($book->path(), [
        'title' => 'New Title',
        'author' => 'New Author',
       ]);
       $this->assertEquals('New Title', Book::first()->title);
       $this->assertEquals('New Author', Book::first()->author);
       $response->assertRedirect($book->fresh()->path());

   }
   public function test_a_book_can_be_deleted(){
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Adrian',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
   }
}
