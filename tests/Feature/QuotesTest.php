<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class QuotesTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    /**
     *@test
     */
    public function whenIndexWasRequiredReturnAllTheQuotesStoredInTheDataBase() //index
    {
        // CREAR la tada en el seed
        $this->seed();
        //cuando tengo la base cargada con 2 quotes con 4 comentaros cada uno, y hago un get al index
        $response = $this->get('/quotes');
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->has('title')
                ->has('message')
                ->has('messages')
                ->has('code')
                ->has('data', 2)
                ->has('data', function (AssertableJson $jsonData) {
                    $jsonData->has('0.comments', 4)
                        ->has('1.comments', 4);
                });
        });
    }

    /**
     * @test
     */
    public function whenIsSendedAQuoteSavedItAndReturnTheQuoteSavedWithZeroComments() //store
    {
        $this->seed();
        $response = $this->post(
            '/quotes',
            [
                "author" => "Author3 Example",
                "text" => "This is a quote3"
            ]
        );
        $response->assertStatus(201);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->has('title')
                ->has('message')
                ->has('messages')
                ->where('code', 201)
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->where("id", 3)
                        ->where("text", "This is a quote3")
                        ->where("author", "Author3 Example")
                        ->has("comments", 0)
                        ->etc();
                });
        });
    }
    /**
     * @test
     */
    public function whenShowWasRequiredReturnTheQuoteCorrectWithComments() //store
    {
        $this->seed();
        $response = $this->post('/quotes/1');
        $response->assertStatus(201);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->has('title')
                ->has('message')
                ->has('messages')
                ->has('code')
                ->has('data', function ($jsonData) {
                    $jsonData
                        ->has("id", 1)
                        ->has("text", "This is a quote1")
                        ->has("author", "Author1 Example")
                        ->has("comments", 4);
                });
        });
    }
}
