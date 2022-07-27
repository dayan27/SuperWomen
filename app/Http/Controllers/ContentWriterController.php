<?php

namespace App\Http\Controllers;

use App\Models\ContentWriter;
use Illuminate\Http\Request;

class ContentWriterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ContentWriter::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
         
        ]);
       
        return ContentWriter::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentWriter  $contentWriter
     * @return \Illuminate\Http\Response
     */
    public function show(ContentWriter $contentWriter)
    {
        return $contentWriter;
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentWriter  $contentWriter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentWriter $contentWriter)
    {
        $contentWriter->update($request->all());
        return $contentWriter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentWriter  $contentWriter
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentWriter $contentWriter)
    {
        $contentWriter->delete();
    }
}
