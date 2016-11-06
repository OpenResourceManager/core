<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\MobileCarrier;
use App\Http\Transformers\MobileCarrierTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobileCarrierController extends ApiController
{
    /**
     * MobileCarrierController constructor.
     */
    public function __construct()
    {
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
            'code' => 'string|required|min:3',
            'label' => 'string|required|max:25',
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

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
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? MobileCarrier::destroy($data['id']) : MobileCarrier::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
