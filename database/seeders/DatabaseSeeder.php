<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $quoteQuantity = 2;
        $CommentQuantity = 4;
        for ($i = 0; $i < $quoteQuantity; $i++) {
            $quote = new Quote();
            $quote->text = "This is a quote".$i;
            $quote->author = "Author{$i} Example";
            $quote->save();
            for ($j = 0; $j < $CommentQuantity; $j++) {
                $comment = new Comment();
                $comment->text = "this is a comment" . $j;
                $comment->quote_id = $quote->id;
                $comment->save();
            }
        }
    }
}
