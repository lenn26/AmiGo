<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Renvoie la liste des universités pour l'autocomplétion
     */
    public function search(Request $request)
    {
        // On renvoie tout car la liste est petite, si on a une grande liste on peut filtre avec :  $request->input('query')
        $universities = University::all(['id', 'name', 'address', 'latitude', 'longitude', 'type']);
        
        return response()->json($universities);
    }
}
