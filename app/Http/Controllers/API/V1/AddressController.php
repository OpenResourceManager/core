<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Address;
use App\Http\Transformers\AddressTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends ApiController
{

    /**
     * AddressController constructor.
     */
    public function __construct()
    {
        $this->noun = 'address';
    }

    /**
     * Show all Addresses
     *
     * Get a paginated array of Addresses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Address::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new AddressTransformer);
    }

    /**
     * Show an Address
     *
     * Display an Address by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Address::findOrFail($id);
        return $this->response->item($item, new AddressTransformer);
    }

    /**
     * Store Address
     *
     * Store an Account's Address.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'account_id' => 'integer|required|exists:accounts,id,deleted_at,NULL',
            'addressee' => 'string|max:50',
            'organization' => 'string|max:50',
            'line_1' => 'string|required|max:50',
            'line_2' => 'string|max:50',
            'city' => 'string|max:50',
            'state_id' => 'integer|required|exists:states,id,deleted_at,NULL',
            'zip' => 'numeric|max:11',
            'country_id' => 'integer|required|exists:countries,id,deleted_at,NULL',
            'latitude' => 'numeric',
            'longitude' => 'numeric'
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        $trans = new AddressTransformer();

        $item = Address::create($data);

        $item = $trans->transform($item);

        return $this->response->created(route('api.addresses.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Address
     *
     * Deletes the specified Address by it's ID.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, ['id' => 'integer|required|min:1|exists:addresses,id,deleted_at,NULL']);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = Address::destroy($data['id']);

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
