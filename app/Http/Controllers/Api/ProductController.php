<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //1 endpoint permettant la récupération de la liste des produits (ajouter la capacité de filtrer sur une catégorie)
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    //1 endpoint permettant la création d’un produit
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    //1 endpoint permettant la récupération d’un produit
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    //1 endpoint permettant l’édition d’un produit
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    //1 endpoint permettant la suppression d’un produit
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
