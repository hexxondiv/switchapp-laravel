<?php


namespace Hexxondiv\SwitchappLaravel\Repositories;

trait SwitchAppTrait
{
    private $base_url;

    private $secret_key;
    private $public_key;
    private $bvn;
    private $pid;

    private $get_all_endpoints;

    private $get_all_bank_accounts;
    private $create_bank_account;

    private $create_bank_account_tag;
    private $get_bank_account_tags;

    private $permanent_number_url;
    private $merchant_settlement_url;
    private $allTransactionsByEmail;
    private $initiate_transfer_url;

    private $resolve_account;
    private $bank_list;

    private $initiate_transaction;
    private $server_initiate_transaction;
    private $server_initiate_invoice;
    private $add_new_beneficiary;
    private $add_new_customer_dva;
    private $fetch_beneficiary_by_details;
    private $fetch_beneficiary;
    private $verify_transaction;
    private $verify_transaction_by_id;
    private $get_dva_transactions_by_ref;
    private $get_all_transactions;
    private $get_wallet_balances;
    private $get_wallet_balances_currency;
    private $settle_to_wallet_url;
    private $settle_to_bank_url;
    private $delete_customer_DVA;
    private $server_initiate_top_up_transaction;
    private $server_initiate_transfer;
    private $verify_top_up;
    private $fetch_transfer_single_ref;
    private $fetch_transfer_batch_ref;

    public function setCredentials($config)
    {

        $this->base_url = 'https://api.switchappgo.com/v1';
        $this->public_key = $config['public_key'];
        $this->secret_key = $config['secret_key'];
        $this->bvn = $config['bvn'];
        $this->pid = $config['pid'] ?? null;

        $this->get_all_endpoints = '';
        $this->get_all_bank_accounts = $this->base_url . '/bank-accounts' . $this->get_all_endpoints;//GET
        $this->create_bank_account = $this->base_url . '/bank-accounts';//POST

        $this->create_bank_account_tag = $this->base_url . '/bank-accounts/tag';//POST
        $this->get_bank_account_tags = $this->base_url . '/bank-accounts/tag' . $this->get_all_endpoints;//GET

        $this->get_primary_bank_account = $this->base_url . '/bank-accounts/primary-bank-account';//GET
        $this->set_primary_bank_account = $this->base_url . '/bank-accounts/set-primary-bank-account';//POST

        $this->resolve_account = $this->base_url . '/banks/resolve-account';//POST
        $this->bank_list = $this->base_url . '/banks';//GET

        $this->initiate_transaction = $this->base_url . '/transactions/initialize';//POST
        $this->server_initiate_transaction = $this->base_url . '/transactions/server-initialize';//POST
        $this->server_initiate_invoice = $this->base_url . '/invoices';//POST
        $this->verify_transaction = $this->base_url . '/transactions/verify/:txRef';//GET {/txRef}
        $this->verify_top_up = $this->base_url . '/top-ups/reference/:txRef';//GET {/txRef}
        $this->get_wallet_balances = $this->base_url . '/balances';//GET
        $this->get_wallet_balances_currency = $this->base_url . '/balances/currency/:currencyCode';//GET {/currency}
        $this->server_initiate_top_up_transaction = $this->base_url . '/top-ups/initialize';//POST

        $this->server_initiate_transfer = $this->base_url . '/transfers/bank';//POST


        $this->verify_transaction_by_id = $this->base_url . '/transactions/:id';//GET {/id}
        $this->settle_to_wallet_url = $this->base_url . '/bank-accounts/settle-to-wallet/:id';//PUT {/id}
        $this->settle_to_bank_url = $this->base_url . '/bank-accounts/settle-to-bank/:id';//PUT {/id}
        $this->add_new_beneficiary = $this->base_url . '/beneficiaries/create/bank-transfer';//POST
        $this->fetch_beneficiary_by_details = $this->base_url . '/beneficiaries/by-details';//POST
        $this->fetch_beneficiary = $this->base_url . '/beneficiaries/:id';//GET {/id}
        $this->fetch_transfer_single_ref = $this->base_url . '/transfers/single/reference/:reference';//GET {/id}
        $this->fetch_transfer_batch_ref = $this->base_url . '/transfers/batch/reference/:reference';//GET {/id}
//        DVA Handles
        $this->delete_customer_DVA = $this->base_url . '/customer-dedicated-accounts/deallocate/:id';//DELETE {/id}
        $this->add_new_customer_dva = $this->base_url . '/customer-dedicated-accounts/create';//POST
        $this->get_dva_transactions_by_ref = $this->base_url . '/transactions/customer-dedicated-account/reference/:order_ref';//GET {/order_ref}
        $this->get_all_transactions = $this->base_url . '/transactions';//GET
    }

    public function confirmSwitchAppPay($ref)
    {
        $result = array();
        $url = str_replace(':txRef', $ref, $this->verify_transaction);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }
    public function confirmSwitchAppTopUp($ref)
    {
        $result = array();
        $url = str_replace(':txRef', $ref, $this->verify_top_up);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }

    public function settleToWallet($id)
    {
        $url = str_replace(':id', $id, $this->settle_to_wallet_url);
        $payload = [
            'url' => $url,
            'custom_request' => "PUT",
        ];
        return $this->makeCall($payload);
    }

    public function settleToBank($id)
    {
        $url = str_replace(':id', $id, $this->settle_to_bank_url);
        $payload = [
            'url' => $url,
            'custom_request' => "PUT",
        ];
        return $this->makeCall($payload);
    }
    public function deleteCustomerDVA($id)
    {
        $url = str_replace(':id', $id, $this->delete_customer_DVA);
        $payload = [
            'url' => $url,
            'custom_request' => "DELETE",
        ];
//        return $payload;
        return $this->makeCall($payload);
    }
    public function createNewDVA($data)
    {
        $url = $this->add_new_customer_dva;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }


    public function getCustomerDVATransactions($orderRef,$payload)
    {
        $url = str_replace(':order_ref', $orderRef, $this->get_dva_transactions_by_ref);
        $data_string = json_encode($payload);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function getCustomerTransactions($payload)
    {
        $url = $this->get_all_transactions;
        $data_string = json_encode($payload);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function confirmSwitchAppPayByID($payment_id)
    {
        $url = str_replace(':id', $payment_id, $this->verify_transaction_by_id);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }

    public function getSwitchAppWalletBalance($currency ='NGN')
    {
        $url = str_replace(':currencyCode', $currency, $this->get_wallet_balances_currency);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }

    /**
     * //Expected format
     * $jayParsedAry = [
     * "bank_account_tags" => [
     * [
     * "bank_account_id" => "string",
     * "tag_name" => "string",
     * "description" => "string"
     * ]
     * ],
     * "account_number" => "string",
     * "bank_code" => "string",
     * "country" => "string",
     * "currency" => "string",
     * "bvn" => "string",
     * "set_as_primary" => true
     * ];
     **/
    public function createOrUpdateAccount($data)
    {
        $url = $this->create_bank_account;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function serverInitiateTransaction($data)
    {
        $url = $this->server_initiate_transaction;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function serverInitiateTopUpTransaction($data)
    {
        $url = $this->server_initiate_top_up_transaction;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function serverInitiateTransfer($data)
    {
        $url = $this->server_initiate_transfer;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function serverInitiateInvoiceLink($data)
    {
        $url = $this->server_initiate_invoice;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function setBeneficiary($data)
    {
        $url = $this->add_new_beneficiary;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function getBeneficiary($data)
    {
        $url = $this->fetch_beneficiary_by_details;
        $data_string = json_encode($data);

        $payload = [
            'url' => $url,
            'custom_request' => "POST",
            'post_fields' => $data_string,
        ];
        return $this->makeCall($payload);
    }
    public function fetchBeneficiary($id)
    {
        $url = str_replace(':id', $id, $this->fetch_beneficiary);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }
    public function fetchTransferSingleRef($ref)
    {
        $url = str_replace(':reference', $ref, $this->fetch_transfer_single_ref);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }
    public function fetchTransferBatchRef($ref)
    {
        $url = str_replace(':reference', $ref, $this->fetch_transfer_batch_ref);
        $payload = [
            'url' => $url,
            'custom_request' => "GET",
        ];
        return $this->makeCall($payload);
    }



    /**
     * @param $data | url, custom_request, post_fields (optional)
     * @return array|mixed
     */
    private function makeCall($data)
    {
        $result = array();
        $url = $data['url'];
        $custom_request = $data['custom_request'];
        $data_string = null;
        if (isset($data['post_fields']) && $custom_request == "POST") {
            $data_string = $data['post_fields'];
            $ch = curl_init($url);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $custom_request);
        if (isset($data['post_fields']) && !is_null($data_string))
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $this->secret_key,
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        if ($response) {
            $result = json_decode($response, true);
        }
//        return $data;
        return $result;
    }

}
