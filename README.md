# SwitchappLaravel Library 
A PHP library for integrating with the SwitchApp API.
### Requirements

- PHP version 7.0 or higher
- Laravel version 5.x or higher

To use this library, you'll first need to register @ [SwitchAppGo](https://switchappgo.com), and then get your developer secret key and public keys from the  [developers page](https://dashboard.switchappgo.com/developers).

### Installation


- Use Composer to install the library:

    ```shell script
     composer require hexxondiv/switchapp-laravel

### Usage
1.  Import the SwitchAppService class:

    `use Hexxondiv\SwitchappLaravel\SwitchAppService;`

2.  Create an instance of the SwitchAppService class:
    ```php
    $switchAppService = new SwitchAppService($config); 
    
   Where `$config` is an array containing the following keys:
    - `public_key:` Your SwitchApp API public key
    - `secret_key:` Your SwitchApp API secret key
    - `bvn:` Your Bank Verification Number (BVN)

- Call any of the available methods on the SwitchAppService instance to interact with the SwitchApp API. 
For example:
    
    ```php
    $payment = $switchAppService->verifyPaymentByID('tx_473453045')->getResult();
    
This code verifies a payment with the ID `tx_473453045` and stores the result in the $payment variable.

### Available Methods
   - `verifyPaymentByID($payment_id):` Verifies a payment by ID.
   - `verifyPayment($tx_ref):` Verifies a payment by transaction reference.
   - `verifyTopUp($ref):` Verifies a top-up transaction by reference.
   - `payoutToWallet($account_id):` Sends a payout to a wallet.
   - `payoutToBank($account_id):` Sends a payout to a bank account.
   - `initializeTx($data):` Initializes a new transaction.
   - `initializeTopUpTx($data):` Initializes a new top-up transaction.
   - `initializeTransfer($data):` Initializes a new transfer.
   - `getTransferSingleReference($ref):` Retrieves a single transfer reference.
   - `getTransferBatchReference($ref):` Retrieves a batch transfer reference.
   - `initializeInvoiceLink($data):` Initializes a new invoice link.
   - `walletBalance($currency = 'NGN'):` Retrieves the wallet balance for a given currency.
   - `createTransferRecipient($data):` Creates a new transfer recipient.
   - `fetchBeneficiary($data):` Retrieves a beneficiary.
   - `deleteDVA($id):` Deletes a DVA (Dedicated Virtual Account) by ID.
   - `newDVA($data):` Creates a new DVA.
   - `getDVATransactions($orderRef, $payload):` Retrieves DVA transactions.
   - `getAllClientTransactions($payload):` Retrieves all client transactions.
    
All methods return a SwitchApp API response object. Call getResult() on the SwitchAppService instance to get the result of the last method call.
  
### Contributing

Contributions to this library are welcome! To contribute, please follow these steps:

- Fork the repository
- Create a new branch for your feature or bugfix
- Make your changes and commit them with clear commit messages
- Push your changes to your fork
- Create a pull request to merge your changes into the main repository

### License
This library is licensed under the MIT license. See the _LICENSE_ file for more information.



