<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Tstore;
use App\Township;


class TownshipController extends Controller
{
    public function index()
    {
        $townships = Township::latest()->get();
        return view('townships.index', compact('townships'));
    }

    public function create()
    {
        return view('townships.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Tstore $request)
    {
        Township::create($request->all()); 
        return redirect()->route('townships.index');       
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Township $township)
    {
        return view('townships.edit', compact('township'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tstore $request, Township $township)
    {
        $township->update($request->all());
        return redirect()->route('townships.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Township $township)
    {
        return view('townships.show', compact('township'));
    }
    
    public function destroy(Township $township)
    {
        $township->delete();
        return redirect()->route('townships.index');
    }
}
