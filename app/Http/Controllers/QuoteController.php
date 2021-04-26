<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotes = Quote::with('comments')->get();
        return $this->defaultJsonResponse(true, "All quotes", "All quotes", [], $quotes);
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
            "text" => "required|max:300",
            "author" => "required|max:30"
        ];
        
        $validator = $this->validateRequestJsonFunction( $request, $rules );
        if(!$validator->validated) {
            return $this->defaultJsonResponseWithoutData(false, "Incorrect Data", "one o more values are incorrect", $validator->errors, 422);
        }
        $quote = new Quote();
        $quote->text = $request->text;
        $quote->author = $request->author;
        if($quote->save()) {
            $quote = Quote::with('comments')->find($quote->id);
            return $this->defaultJsonResponse(true, "Quote Created", "The quote has created successfully",[], $quote, 201);
        };
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        $quote = Quote::with('comments')->find($quote->id);

        return $this->defaultJsonResponse(true, "Quote Found", "The Quote with id: {$quote->id} has found", null, $quote );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
