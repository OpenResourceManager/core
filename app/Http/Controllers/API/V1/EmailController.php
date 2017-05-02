<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Account;
use App\Http\Models\API\Email;
use App\Http\Transformers\EmailTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;
use Krucas\Settings\Facades\Settings;
use Snowfire\Beautymail\Beautymail;

class EmailController extends ApiController
{
    /**
     * EmailController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'email';
    }

    /**
     * Show all Emails
     *
     * Get a paginated array of Emails.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $emails = Email::paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * Show verified Emails
     *
     * Show a paginated array of Emails that are verified.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function showVerified()
    {
        $emails = Email::where('verified', true)->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);

    }

    /**
     * Show verified Emails for an Account
     *
     * Show a paginated array of Emails that are verified and owned by the specified account.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showVerifiedForAccount($id)
    {
        $emails = Email::where('verified', true)->where('account_id', $id)->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);

    }

    /**
     * Show unverified Emails
     *
     * Show a paginated array of Emails that are not verified.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function showUnverified()
    {
        $emails = Email::where('verified', false)->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * Show unverified Emails for an Account
     *
     * Show a paginated array of Emails that are not verified and owned by the specified account.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showUnverifiedForAccount($id)
    {
        $emails = Email::where('verified', false)->where('account_id', $id)->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * Show a Email
     *
     * Display an Email by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Email::findOrFail($id);
        return $this->response->item($item, new EmailTransformer);
    }

    /**
     * Show Email by Address
     *
     * Display an Email by providing it's Address attribute.
     *
     * @param $address
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAddress($address)
    {
        $item = Email::where('address', $address)->firstOrFail();
        return $this->response->item($item, new EmailTransformer);
    }

    /**
     * Show Email by Account ID
     *
     * Display Emails by providing an Account ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAccountId($id)
    {
        $emails = Email::where('account_id', $id)->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * Show Email by Account Identifier
     *
     * Display Emails by providing an Account Identifier attribute.
     *
     * @param $identifier
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAccountIdentifier($identifier)
    {
        $emails = Account::where('identifier', $identifier)->firstOrFail()->emails()->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * Show Email by Account Username
     *
     * Display Emails by providing an Account Username attribute.
     *
     * @param $username
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAccountUsername($username)
    {
        $emails = Account::where('username', $username)->firstOrFail()->emails()->paginate($this->resultLimit);
        return $this->response->paginator($emails, new EmailTransformer);
    }

    /**
     * Store/Update/Restore Email
     *
     * Create or update Email information.
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
            'address' => 'email|required',
            'verified' => 'boolean'
        ]);
        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());


        $excluded_domains = Settings::get('excluded-email-domains', []);
        $email_domain = explode('@', $data['address'])[1];
        if (!empty($excluded_domains)) {
            if (in_array($email_domain, $excluded_domains))
                throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', ['The email address entered is a member of a forbidden domain: ' . $email_domain]);
        }

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

        if ($toRestore = Email::onlyTrashed()->where('address', $data['address'])->first()) $toRestore->restore();
        $trans = new EmailTransformer();
        $item = Email::updateOrCreate(['address' => $data['address']], $data);
        $item->verification_token = ($item->verified) ? null : generateVerificationToken();
        $item->save();

        // If the email is not verified
        if (!$item->verified) {
            // Are we set up to verify emails?
            $verification_url = Settings::get('asset-verification-server-url', '');
            $confirmation_from_address = Settings::get('confirmation-from-address', '');
            $logo = ['path' => Settings::get('logo-url', ''), 'width' => 400, 'height' => ''];

            if (!empty($verification_url) && !empty($confirmation_from_address)) {
                // Build the verification url
                $verification_url = fixPath(fixPath($verification_url) . 'verify/' . $item->verification_token);
                // Build the mail class
                $beautymail = app()->make(Beautymail::class);
                // Send the message
                $beautymail->send('emails.confirm', ['logo' => $logo, 'url' => $verification_url, 'token' => $item->verification_token],
                    function ($message) use ($item, $confirmation_from_address) {
                        $message
                            ->from($confirmation_from_address)
                            ->to($item->address, $item->account->format_full_name())
                            ->subject('Welcome! Verify your email.');
                    });
            }
        }

        $item = $trans->transform($item);
        return $this->response->created(route('api.emails.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Email
     *
     * Deletes the specified Email by it's ID or Address attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'address' => 'email|required_without:id|exists:emails,address,deleted_at,NULL',
            'id' => 'integer|required_without:address|exists:emails,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $deleted = (array_key_exists('id', $data)) ? Email::destroy($data['id']) : Email::where('address', $data['address'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
