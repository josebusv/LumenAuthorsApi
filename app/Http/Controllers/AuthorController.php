<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return an instance of Author
     * @return Illuminate\Http\Response
     */
    public function index()
    {

        $authors = Author::all();

        return $this->successResponse($authors);

    }
    /**
     * Return an specific Author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name'  => 'required|max:255',
            'gender'  => 'required|max:255|in:male,female',
            'country'  => 'required|max:255'
        ];
        
        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);

    }
    /**
     * Return an instance of Author
     * @return Illuminate\Http\Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);

        return $this->successResponse($author);

    }
    /**
     * Update the information of an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'name'  => 'max:255',
            'gender'  => 'max:255|in:male,female',
            'country'  => 'max:255'
        ];
        
        $this->validate($request, $rules);

        $author = Author::findOrFail($author);

        $author->fill($request->all());

        if ($author->isClean()){
            return $this->errorResponse('At least one vlue must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();

        return $this->successResponse($author);
    }
    /**
     * Remove an instance of Author
     * @return Illuminate\Http\Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);

        $author->delete();

        return $this->successResponse($author);
    }

}
