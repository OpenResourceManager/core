<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\UUD\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    /**
     * @var UserTransformer
     */
    protected $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     */
    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = Input::get('limit') ?: 25;
        $limit = $limit > 100 ? 100 : $limit;
        $result = User::paginate($limit);

        $next = $request->path();
        $next = $limit == 25 ? $next . '?page=' . strval(((int)$result->currentPage() + 1)) : $next . '?limit=' . $result->perPage() . '&page=' . strval(((int)$result->currentPage() + 1));
        $next = $next >= $result->lastPage() ? null : $next;

        $previous = $request->path();
        $previous = $limit == 25 ? $previous . '?page=' . strval(((int)$result->currentPage() - 1)) : $previous . '?limit=' . $result->perPage() . '&page=' . strval(((int)$result->currentPage() - 1));
        $previous = ((int)$result->currentPage() - 1) > 0 ? $previous : null;

        $paginator = [
            'total_count' => $result->lastPage(),
            'total_pages' => ceil($result->lastPage() / $result->perPage()),
            'current_page' => $result->currentPage(),
            'limit' => (int)$result->perPage(),
            'next_page' => $next,
            'previous_page' => $previous
        ];
        return $this->respondWithSuccess($this->userTransformer->transformCollection($result->all()), $paginator);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|max:7|min:6|unique:users,deleted_at,NULL',
            'name_prefix' => 'string|max:7',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:7',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3|unique:users,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = User::create(Input::all());
        return $this->respondCreateSuccess($id = $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = User::find($id);
        if (!$result) return $this->respondNotFound();
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
