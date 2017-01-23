<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Address;
use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Transformers\AddressTransformer;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Http\Models\API\Account;
use Illuminate\Support\Facades\Validator;

class AddressController extends ApiController
{

    /**
     * AddressController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
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
            'account_id' => 'integer|required_without_all:username,identifier|exists:accounts,id,deleted_at,NULL',
            'username' => 'string|required_without_all:account_id,identifier|exists:accounts,username,deleted_at,NULL',
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'addressee' => 'string|max:50|required',
            'organization' => 'string|max:50',
            'line_1' => 'string|required|max:50',
            'line_2' => 'string|max:50',
            'city' => 'string|max:50|required',
            'state_id' => 'integer|required_without:state_code|exists:states,id,deleted_at,NULL',
            'state_code' => 'string|required_without:state_id|exists:states,code,deleted_at,NULL',
            'zip' => 'numeric|required',
            'country_id' => 'integer|required_without:country_code|exists:countries,id,deleted_at,NULL',
            'country_code' => 'string|required_without:country_id|exists:countries,code,deleted_at,NULL',
            'latitude' => 'numeric',
            'longitude' => 'numeric'
        ]);

        if ($validator->fails())
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        /**
         * Translate account identifier or username to an id if needed
         */
        if (!array_key_exists('account_id', $data)) {
            if (array_key_exists('identifier', $data)) {
                $account = Account::where('identifier', $data['identifier'])->firstOrFail();
            } elseif (array_key_exists('username', $data)) {
                $account = Account::where('username', $data['username'])->firstOrFail();
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
            }
            $data['account_id'] = $account->id;
        }

        /**
         * Translate state code to an id if needed
         */
        if (!array_key_exists('state_id', $data)) {
            if (array_key_exists('state_code', $data)) {
                $data['state_id'] = State::where('code', $data['state_code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "state_id" or "state_code".']);
            }
        }

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

        $validator = Validator::make($data, ['id' => 'integer|required|exists:addresses,id,deleted_at,NULL']);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = Address::destroy($data['id']);

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
