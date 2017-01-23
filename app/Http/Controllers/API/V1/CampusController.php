<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Campus\CampusesViewed;
use App\Events\Api\Campus\CampusRestored;
use App\Events\Api\Campus\CampusViewed;
use App\Http\Models\API\Campus;
use App\Http\Transformers\CampusTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;

class CampusController extends ApiController
{

    /**
     * CampusController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->noun = 'campus';
    }

    /**
     * Show all Campuses
     *
     * Get a paginated array of Campuses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $campuses = Campus::paginate($this->resultLimit);
        event(new CampusesViewed($campuses->pluck('id')->toArray()));
        return $this->response->paginator($campuses, new CampusTransformer);
    }

    /**
     * Show a Campus
     *
     * Display a Campus by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Campus::findOrFail($id);
        event(new CampusViewed($item));
        return $this->response->item($item, new CampusTransformer);
    }

    /**
     * Show Campus by Code
     *
     * Display a Campus by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Campus::where('code', $code)->firstOrFail();
        event(new CampusViewed($item));
        return $this->response->item($item, new CampusTransformer);
    }

    /**
     * Store/Update/Restore Campus
     *
     * Create or update Campus information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required|max:10|min:3',
            'label' => 'string|required|max:30|min:3'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Campus::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }
        $trans = new CampusTransformer();
        $item = Campus::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.campuses.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:campuses,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:campuses,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? Campus::destroy($data['id']) : Campus::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
