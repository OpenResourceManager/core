<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\MobileCarrier;
use App\Http\Models\API\MobilePhone;
use App\Http\Transformers\MobilePhoneTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\API\Account;
use Dingo\Api\Exception\StoreResourceFailedException;
use Krucas\Settings\Facades\Settings;

class MobilePhoneController extends ApiController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
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
        $mobilePhones = MobilePhone::paginate($this->resultLimit);
        return $this->response->paginator($mobilePhones, new MobilePhoneTransformer);
    }

    /**
     * Show verified Mobile Phones
     *
     * Show a paginated array of Mobile Phones that are verified.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function showVerified()
    {
        $mobilePhones = MobilePhone::where('verified', true)->paginate($this->resultLimit);
        return $this->response->paginator($mobilePhones, new MobilePhoneTransformer);
    }

    /**
     * Show verified Mobile Phones for an Account
     *
     * Show a paginated array of Mobile Phones that are verified and owned by the specified account.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showVerifiedForAccount($id)
    {
        $mobilePhones = MobilePhone::where('verified', true)->where('account_id', $id)->paginate($this->resultLimit);
        return $this->response->paginator($mobilePhones, new MobilePhoneTransformer);
    }

    /**
     * Show unverified Mobile Phones
     *
     * Show a paginated array of Mobile Phones that are not verified.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function showUnverified()
    {
        $mobilePhones = MobilePhone::where('verified', false)->paginate($this->resultLimit);
        return $this->response->paginator($mobilePhones, new MobilePhoneTransformer);
    }

    /**
     * Show unverified Mobile Phones for an Account
     *
     * Show a paginated array of Mobile Phones that are not verified and owned by the specified account.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showUnverifiedForAccount($id)
    {
        $mobilePhones = MobilePhone::where('verified', false)->where('account_id', $id)->paginate($this->resultLimit);
        return $this->response->paginator($mobilePhones, new MobilePhoneTransformer);
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
     * Show Mobile Phones by Account ID
     *
     * Display Mobile Phone by providing an Account ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAccountId($id)
    {
        $phones = MobilePhone::where('account_id', $id)->paginate($this->resultLimit);
        return $this->response->paginator($phones, new MobilePhoneTransformer);
    }

    /**
     * Show Mobile Phones by Account Identifier
     *
     * Display Mobile Phone by providing an Account Identifier attribute.
     *
     * @param $identifier
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAccountIdentifier($identifier)
    {
        $phones = Account::where('identifier', $identifier)->firstOrFail()->mobilePhones()->paginate($this->resultLimit);
        return $this->response->paginator($phones, new MobilePhoneTransformer);
    }

    /**
     * Show Mobile Phones by Account Username
     *
     * Display Mobile Phone by providing an Account Username attribute.
     *
     * @param $username
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAccountUsername($username)
    {
        $phones = Account::where('username', $username)->firstOrFail()->mobilePhones()->paginate($this->resultLimit);
        return $this->response->paginator($phones, new MobilePhoneTransformer);
    }

    /**
     * Show Mobile Phones by Mobile Carrier ID
     *
     * Display Mobile Phones by providing an Mobile Carrier ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showFromMobileCarrierId($id)
    {
        $phones = MobileCarrier::findOrFail($id)->mobilePhones()->paginate($this->resultLimit);
        return $this->response->paginator($phones, new MobilePhoneTransformer);
    }

    /**
     * Show Mobile Phones by Mobile Carrier Code
     *
     * Display Mobile Phones by providing an Mobile Carrier Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromMobileCarrierCode($code)
    {
        $phones = MobileCarrier::where('code', $code)->firstOrFail()->mobilePhones()->paginate($this->resultLimit);
        return $this->response->paginator($phones, new MobilePhoneTransformer);
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
            'identifier' => 'alpha_num|required_without_all:account_id,username|max:7|min:6|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|min:3|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|min:1|exists:accounts,id,deleted_at,NULL',
            'number' => 'string|required|size:10',
            'country_code' => 'string|max:4',
            'mobile_carrier_id' => 'integer|min:1|required_without:mobile_carrier_code|exists:mobile_carriers,id,deleted_at,NULL',
            'mobile_carrier_code' => 'string|min:3|required_without:mobile_carrier_id|exists:mobile_carriers,code,deleted_at,NULL',
            'verified' => 'boolean',
            'confirmation_from' => 'email',
            'upstream_app_name' => 'string'
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
         * Translate mobile carrier code to an id if needed
         */
        if (!array_key_exists('mobile_carrier_id', $data)) {
            if (array_key_exists('mobile_carrier_code', $data)) {
                $data['mobile_carrier_id'] = MobileCarrier::where('code', $data['mobile_carrier_code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "mobile_carrier_id" or "mobile_carrier_code".']);
            }
        }

        $trans = new MobilePhoneTransformer();

        if ($toRestore = MobilePhone::onlyTrashed()->where('number', $data['number'])->first()) $toRestore->restore();

        $item = MobilePhone::updateOrCreate(['number' => $data['number']], $data);
        $item->verification_token = ($item->verified) ? null : generateVerificationToken();
        $item->save();

        // Start verification if we can and if it's needed
        $verification_url = Settings::get('asset-verification-server-url', '');
        if (!$item->verified && !empty($item->verification_token) && !empty($verification_url)) {
            // Build the message string with some context if available
            $message = (empty($data['upstream_app_name'])) ? $data['upstream_app_name'] . " mobile phone verification:\n" : "Mobile phone verification:\n";
            $message = $message . "Your verification code is: " . $item->verification_token . "\nTo verify this phone number visit:\n" . fixPath(fixPath($verification_url) . 'verify/' . $item->verification_token);
            // Send the SMS message
            sendSMS($message,$item->number, $item->carrier->code);
        }

        // Return the transformed item
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
            'id' => 'integer|required|exists:mobile_phones,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = MobilePhone::destroy($data['id']);

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
