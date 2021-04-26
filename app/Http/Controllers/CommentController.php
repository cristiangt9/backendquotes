<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = Comment::query();
        $title = "All Comments";
        if($request->has('quote_id')){
            $comments = $comments->where("quote_id", $request->quote_id);
            $title .= " of quote_id: ".$request->quote_id;
        }
        $comments = $comments->get();

        return $this->defaultJsonResponse(true, $title, "Comments found", null, $comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "text" => "required|max:200",
            "quote_id" => "required|exists:quotes,id"
        ];

        $validator = $this->validateRequestJsonFunction($request, $rules);
        if(!$validator->validated) {
            return $this->defaultJsonResponseWithoutData(false, "Incorrect Data", "One o more fields are incorrect", $validator->error, 422);
        }

        $comment = new Comment();
        $comment->text = $request->text;
        $comment->quote_id = $request->quote_id;
        if($comment->save()) {
            $comments = Comment::where("quote_id", $request->quote_id)->get();
            return $this->defaultJsonResponse(true, "Comment created", "the comment has created successfully", null, ['comments' => $comments], 201);
        }
        return $this->defaultJsonResponseWithoutData(false, "Error during creation", "please contact with support", null, 422);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
