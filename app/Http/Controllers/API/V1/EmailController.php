<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Email;
use App\Http\Transformers\EmailTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailController extends ApiController
{
    /**
     * EmailController constructor.
     */
    public function __construct()
    {
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
        $accounts = Email::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new EmailTransformer);
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
     * Show Duty by Address
     *
     * Display an Email by providing it's Address attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAddress($address)
    {
        $item = Email::where('address', $address)->firstOrFail();
        return $this->response->item($item, new EmailTransformer);
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
            'account_id' => 'integer|required|exists:accounts,id,deleted_at,NULL',
            'address' => 'email|required',
            'verified' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException(
                'Could not store ' . $this->noun . '.',
                $validator->errors()
            );
        }

        $excluded_domains = explode(',', env('EMAIL_MODEL_EXCLUDE_DOMAINS', ''));
        $email_domain = explode('@', $data['address'])[1];

        if (!empty($excluded_domains)) {
            if (in_array($email_domain, $excluded_domains)) {
                throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', [
                    'The email address entered is a member of a forbidden domain: ' . $email_domain
                ]);
            }
        }

        if ($toRestore = Email::onlyTrashed()->where('address', $data['address'])->first()) $toRestore->restore();

        $trans = new EmailTransformer();

        $item = Email::updateOrCreate(['address' => $data['address']], $data);

        $item->verification_token = ($item->verified) ? null : generateVerificationToken();

        $item->save();

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
            'address' => 'string|required_without:id|exists:emails,deleted_at,NULL',
            'id' => 'integer|required_without:address|min:1|exists:emails,deleted_at,NULL'
        ]);

        if ($validator->fails()) throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors());

        $item = (array_key_exists('id', $data)) ? Email::findOrFail($data['id']) : Email::where('address', $data['address'])->firstOrFail();

        return ($item->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}
