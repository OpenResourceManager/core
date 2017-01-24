<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\MobileCarrier;
use App\Http\Transformers\MobileCarrierTransformer;
use Illuminate\Http\Request;
use App\Http\Models\API\Country;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;

class MobileCarrierController extends ApiController
{
    /**
     * MobileCarrierController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'mobile carrier';
    }

    /**
     * Show all MobileCarriers
     *
     * Get a paginated array of MobileCarriers.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = MobileCarrier::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new MobileCarrierTransformer);
    }

    /**
     * Show a MobileCarrier
     *
     * Display a Mobile Carrier by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = MobileCarrier::findOrFail($id);
        return $this->response->item($item, new MobileCarrierTransformer);
    }

    /**
     * Show MobileCarrier by Code
     *
     * Display a Mobile Carrier by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = MobileCarrier::where('code', $code)->firstOrFail();
        return $this->response->item($item, new MobileCarrierTransformer);
    }

    /**
     * Store/Update/Restore Mobile Carrier
     *
     * Create or update Mobile Carrier information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'country_id' => 'integer|required_without:country_code|exists:countries,id,deleted_at,NULL',
            'country_code' => 'string|required_without:country_id|exists:countries,code,deleted_at,NULL',
            'code' => 'string|required|min:3',
            'label' => 'string|required|max:25',
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

        if ($toRestore = MobileCarrier::onlyTrashed()->where('code', $data['code'])->first()) $toRestore->restore();
        $trans = new MobileCarrierTransformer();
        $item = MobileCarrier::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.mobile-carriers.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Mobile Carrier
     *
     * Deletes the specified Mobile Carrier by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:mobile_carriers,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:mobile_carriers,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? MobileCarrier::destroy($data['id']) : MobileCarrier::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
