<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;;

use App\Http\Resources\AuthorResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Cache::remember('authors', 60, function () {
            return Author::all();
        });
        $data    = AuthorResource::collection($authors);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'age'        => $request->age,
        ]);
        $data = new AuthorResource($author);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $data = new AuthorResource($author);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->first_name = $request->input('first_name') ?? $author->first_name;
        $author->last_name  = $request->input('last_name') ?? $author->last_name;
        $author->age        = $request->input('age') ?? $author->age;

        $author->save();
        $data = new AuthorResource($author);
        return $this->customeResponse($data, 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->books()->detach();
        $author->delete();
        return response()->json(['message' => 'Author Deleted'], 200);
    }
}
