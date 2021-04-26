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
    public function whenIndexWasRequiredGetAllTheComments()
    {

        $response = $this->get('/comments/allOfQuote?quote_id=1');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->has('title')
                ->has('message')
                ->has('messages')
                ->has('data', function ($jsonData) {
                    $jsonData->has('comments', 4);
                });
        });
    }
    /**
     * @test
     */
    public function whenACommentWasSendedSaveTheCommentAndReturnAllTheCommentsOfTheQuote()
    {
        $response = $this->post(
            '/comments',
            [
                'comment' =>
                [
                    "text" => "this is a comment4",
                    "quote_id" => "1"
                ]
            ]
        );
        $response->assertStatus(201);
        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('success')
                ->has('title')
                ->has('message')
                ->has('messages')
                ->has('data', function ($jsonData) {
                    $jsonData->has('comments', 5)
                    ->has('comments.4', function ($jsonComment) {
                        $jsonComment->has("id")
                                    ->where("text", "this is a comment4")
                                    ->where("quote_id", "1");
                    });
                });
        });
    }
}