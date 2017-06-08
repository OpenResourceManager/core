<?php

namespace App\Http\Controllers\API\V1;



use App\Http\Models\API\School;
use App\Http\Transformers\SchoolTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Events\Api\LoadStatus\LoadStatusesViewed;
use App\Events\Api\LoadStatus\LoadStatusViewed;

class SchoolController extends ApiController
{
    /**
     * SchoolController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'school';
    }

    /**
     * Show all Schools
     *
     * Get a paginated array of Schools.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $schools = School::paginate($this->resultLimit);
        //event(new LoadStatusesViewed($load_statuses->pluck('id')->toArray()));
        return $this->response->paginator($schools, new SchoolTransformer);
    }

    /**
     * Show a School
     *
     * Display a School by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = School::findOrFail($id);
        //event(new LoadStatusViewed($item));
        return $this->response->item($item, new SchoolTransformer);
    }

    /**
     * Show School by Code
     *
     * Display a School by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = School::where('code', $code)->firstOrFail();
        //event(new LoadStatusViewed($item));
        return $this->response->item($item, new SchoolTransformer);
    }

    /**
     * Store/Update/Restore School
     *
     * Create or update School information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'code' => 'alpha_dash|required|min:3|max:15',
            'label' => 'string|required|max:50|min:3',
        ]);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
        }
        if ($toRestore = School::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }
        $trans = new SchoolTransformer();
        $item = School::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.schools.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy School
     *
     * Deletes the specified School by it's ID or Code attribute.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:schools,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:schools,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) {
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());
        }
        $deleted = (array_key_exists('id', $data)) ? School::destroy($data['id']) : School::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
