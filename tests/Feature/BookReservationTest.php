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
         'author' => 'Victor',
       ]);
       $response->assertOk();
       $this->assertCount(1, Book::all());
   }

   public function test_a_title_is_required() {

    $response = $this->post('/books', [
      'title' => '',
      'author' => 'Victor',
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
}
