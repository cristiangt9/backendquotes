<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    /**
     * @test
     */
    public function whenIndexWasRequiredGetAllTheComments() //index
    {
        $this->seed();
        $response = $this->get('/comments?quote_id=1');
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->has('title')
                ->has('message')
                ->has('messages')
                ->where('code', 200)
                ->has('data', 4);
        });
    }
    /**
     * @test
     */
    public function whenACommentWasSendedSaveTheCommentAndReturnAllTheCommentsOfTheQuote() //store
    {
        $this->seed();
        $response = $this->post(
            '/comments',
            [
                "text" => "this is a comment4",
                "quote_id" => "1"
            ]
        );
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->where('code', 201)
                ->has('data', function ($jsonData) {
                    $jsonData->has('comments', 5)
                        ->has('comments.4', function ($jsonComment) {
                            $jsonComment->has("id")
                                ->where("text", "this is a comment4")
                                ->where("quote_id", 1)
                                ->etc();
                        });
                })
                ->etc();
        });
    }
}
