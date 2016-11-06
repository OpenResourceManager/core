<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\MobilePhone;
use App\Http\Transformers\MobilePhoneTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilePhoneController extends ApiController
{
    /**
     * MobilePhoneController constructor.
     */
    public function __construct()
    {
        $this->noun = 'mobile phone';
    }

    /**
     * Show all MobilePhones
     *
     * Get a paginated array of MobilePhones.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = MobilePhone::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new MobilePhoneTransformer);
    }

    /**
     * Show a MobilePhone
     *
     * Display a Mobile Phone by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = MobilePhone::findOrFail($id);
        return $this->response->item($item, new MobilePhoneTransformer);
    }

    /**
     * Store Mobile Phone
     *
     * Create Mobile Phone entry.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'account_id' => 'integer|required|exists:accounts,id,deleted_at,NULL',
            'number' => 'string|required|size:10',
            'country_code' => 'string|min:1|max:4',
            'mobile_carrier_id' => 'integer|min:1|required_without:mobile_carrier_code|exists:mobile_carriers,id,deleted_at,NULL',
            'mobile_carrier_code' => 'string|min:3|required_without:mobile_carrier_id|exists:mobile_carriers,code,deleted_at,NULL',
            'verified' => 'boolean'
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        $trans = new MobilePhoneTransformer();

        $item = MobilePhone::create($data);

        $item->verification_token = ($item->verified) ? null : generateVerificationToken();

        $item->save();

        $item = $trans->transform($item);

        return $this->response->created(route('api.mobile-phones.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Mobile Phone
     *
     * Deletes the specified Mobile Phone by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'integer|required|min:1|exists:mobile_phones,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = MobilePhone::destroy($data['id']);

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
