<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Country;
use App\Http\Transformers\CountryTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends ApiController
{
    /**
     * CountryController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'country';
    }

    /**
     * Show all Countries
     *
     * Get a paginated array of Countries.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Country::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new CountryTransformer);
    }

    /**
     * Show a Country
     *
     * Display a Country by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Country::findOrFail($id);
        return $this->response->item($item, new CountryTransformer);
    }

    /**
     * Show Duty by Country
     *
     * Display a Country by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Country::where('code', $code)->firstOrFail();
        return $this->response->item($item, new CountryTransformer);
    }

    /**
     * Store/Update/Restore Country
     *
     * Create or update Country information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required|max:15|min:3',
            'abbreviation' => 'string|required|max:3|min:2',
            'label' => 'string|required|max:50|min:3'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Country::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();
        $trans = new CountryTransformer();
        $item = Country::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.countries.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Country
     *
     * Deletes the specified Country by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'alpha' => 'string|required_without:id|exists:countries,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:countries,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());
        $deleted = (array_key_exists('id', $data)) ? Country::destroy($data['id']) : Country::where('code', $data['code'])->firstOrFail()->delete();
        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
