<?php
/**
 * Invoice Ninja (https://invoiceninja.com).
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Transformers;

use App\Models\CompanyGateway;
use App\Transformers\GatewayTransformer;
use App\Utils\Traits\MakesHash;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

/**
 * Class CompanyGatewayTransformer.
 */
class CompanyGatewayTransformer extends EntityTransformer
{
    use MakesHash;
    use SoftDeletes;
    /**
     * @var array
     */
    protected $defaultIncludes = [
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'gateway',
    ];

    /**
     * @param CompanyGateway $company_gateway
     *
     * @return array
     */
    public function transform(CompanyGateway $company_gateway)
    {
        return [
            'id' => (string) $this->encodePrimaryKey($company_gateway->id),
            'gateway_key' => (string) $company_gateway->gateway_key ?: '',
            'accepted_credit_cards' => (int) $company_gateway->accepted_credit_cards,
            'require_cvv' => (bool) $company_gateway->require_cvv,
            'require_billing_address' => (bool) $company_gateway->require_billing_address,
            'require_shipping_address' => (bool) $company_gateway->require_shipping_address,
            'require_client_name' => (bool) $company_gateway->require_client_name,
            'require_zip' => (bool) $company_gateway->require_zip,
            'require_client_phone' => (bool) $company_gateway->require_client_phone,
            'require_contact_name' => (bool) $company_gateway->require_contact_name,
            'require_contact_email' => (bool) $company_gateway->require_contact_email,
            'show_billing_address' => (bool) $company_gateway->show_billing_address, //@deprecated
            'show_shipping_address' => (bool) $company_gateway->show_shipping_address, //@deprecated
            'update_details' => (bool) $company_gateway->update_details,
            'config' => (string) $company_gateway->getConfigTransformed(),
            'fees_and_limits' => $company_gateway->fees_and_limits ?: new stdClass,
            'updated_at' => (int) $company_gateway->updated_at,
            'archived_at' => (int) $company_gateway->deleted_at,
            'created_at' => (int) $company_gateway->created_at,
            'is_deleted' => (bool) $company_gateway->is_deleted,
            'custom_value1' => $company_gateway->custom_value1 ?: '',
            'custom_value2' => $company_gateway->custom_value2 ?: '',
            'custom_value3' => $company_gateway->custom_value3 ?: '',
            'custom_value4' => $company_gateway->custom_value4 ?: '',
            'label' => (string) $company_gateway->label ?: '',
            'token_billing' => (string) $company_gateway->token_billing,
            'test_mode' => (bool) $company_gateway->isTestMode(),
        ];
    }

    public function includeGateway(CompanyGateway $company_gateway)
    {
        $transformer = new GatewayTransformer($this->serializer);

        return $this->includeItem($company_gateway->gateway, $transformer, Gateway::class);
    }
}
