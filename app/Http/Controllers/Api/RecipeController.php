<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeMomentRequest;
use App\Http\Resources\Campaign\MenuAlfamart;
use App\Models\Recipe;
use App\Models\RecipeMoment;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::all();

        return MenuAlfamart::collection($recipes);
    }

    public function getByMoment(RecipeMomentRequest $request)
    {
        $moment = $request->moment;

        $query = RecipeMoment::findBySlug($moment);


        return $query->recipes;

        // $query = $query->with('recipes');

        return MenuAlfamart::collection($query->recipes->sortBy('sort'));
    }
}
