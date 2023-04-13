<?php
namespace Hexxondiv\SwitchappLaravel;

use Hexxondiv\SwitchappLaravel\Repositories\SwitchAppTrait;

class SwitchAppService
{

    use SwitchAppTrait;

    private $result;

    /**
     * SwitchAppService constructor.
     * Initialize SwitchAppService with the following Params
     * @param $config ['public_key','secret_key','bvn']
     */
    public function __construct($config)
    {
        $this->setCredentials($config);
        $this->result = [];
    }

    /**
     * @param $data
     * @return $this
     */
    public function newBankAccount($data)
    {
        $this->result = $this->createOrUpdateAccount($data);
        return $this;
    }

    /**
     * @param $payment_id
     * @return $this
     *
     * combine this with getResult to get the end result of the operation
     * For example
     * $switchAppService->verifyPaymentByID('tx_473453045')->getResult();
     */
    public function verifyPaymentByID($payment_id)
    {

        $this->result = $this->confirmSwitchAppPayByID($payment_id);
        return $this;
    }

    public function verifyPayment($ref)
    {
        $this->result = $this->confirmSwitchAppPay($ref);
        return $this;
    }

    public function verifyTopUp($ref)
    {
        $this->result = $this->confirmSwitchAppTopUp($ref);
        return $this;
    }

    public function payoutToWallet($account_id)
    {
        $this->result = $this->settleToWallet($account_id);
        return $this;
    }

    public function payoutToBank($account_id)
    {
        $this->result = $this->settleToBank($account_id);
        return $this;
    }

    public function initializeTx($data)
    {
        $this->result = $this->serverInitiateTransaction($data);
        return $this;
    }

    public function initializeTopUpTx($data)
    {
        $this->result = $this->serverInitiateTopUpTransaction($data);
        return $this;
    }

    public function initializeTransfer($data)
    {
        $this->result = $this->serverInitiateTransfer($data);
        return $this;
    }

    public function getTransferSingleReference($ref)
    {
        $this->result = $this->fetchTransferSingleRef($ref);
        return $this;
    }

    public function getTransferBatchReference($ref)
    {
        $this->result = $this->fetchTransferBatchRef($ref);
        return $this;
    }

    public function initializeInvoiceLink($data)
    {
        $this->result = $this->serverInitiateInvoiceLink($data);
        return $this;
    }

    public function walletBalance($currency = 'NGN')
    {
        $this->result = $this->getSwitchAppWalletBalance($currency);
        return $this;
    }

    public function createTransferRecipient($data)
    {
        $this->result = $this->setBeneficiary($data);
        return $this;
    }

    public function fetchBeneficiary($data)
    {
        $this->result = $this->getBeneficiary($data);
        return $this;
    }

    // DVA Handles
    public function deleteDVA($id)
    {
        $this->result = $this->deleteCustomerDVA($id);
        return $this;
    }

    public function newDVA($data)
    {
        $this->result = $this->createNewDVA($data);
        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getDVATransactions($orderRef, $payload)
    {
        $this->result = $this->getCustomerDVATransactions($orderRef, $payload);
        return $this;
    }
    public function getAllClientTransactions($payload)
    {
        $this->result = $this->getCustomerTransactions($payload);
        return $this;
    }
}
