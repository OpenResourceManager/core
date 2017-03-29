<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Transformers\StateTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;

class StateController extends ApiController
{
    /**
     * StateController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'state';
    }

    /**
     * Show all States
     *
     * Get a paginated array of States.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = State::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new StateTransformer);
    }

    /**
     * Show a State
     *
     * Display a State by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = State::findOrFail($id);
        return $this->response->item($item, new StateTransformer);
    }

    /**
     * Show State by Code
     *
     * Display a State by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = State::where('code', $code)->firstOrFail();
        return $this->response->item($item, new StateTransformer);
    }

    /**
     * Store/Update/Restore State
     *
     * Create or update State information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'country_id' => 'integer|required_without:country_code|exists:countries,id,deleted_at,NULL',
            'country_code' => 'alpha|required_without:country_id|exists:countries,code,deleted_at,NULL',
            'code' => 'string|required|max:15|min:3',
            'label' => 'string|required|max:50|min:3'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        /**
         * Translate country code to an id if needed
         */
        if (!array_key_exists('country_id', $data)) {
            if (array_key_exists('country_code', $data)) {
                $data['country_id'] = Country::where('code', $data['country_code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "country_id" or "country_code".']);
            }
        }

        if ($toRestore = State::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();
        $trans = new StateTransformer();
        $item = State::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.states.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy State
     *
     * Deletes the specified State by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:states,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:states,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? State::destroy($data['id']) : State::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
