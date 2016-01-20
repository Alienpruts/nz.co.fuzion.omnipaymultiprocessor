<?php

namespace Omnipay\Mollie\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Mollie Complete Purchase Request
 *
 * @method \Omnipay\Mollie\Message\CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
    public function getData()
    {
        $this->validate('apiKey');

        $data = array();
        $data['id'] = $this->getTransactionReference();

        if (!isset($data['id'])) {
            $data['id'] = $this->httpRequest->request->get('id');
        }

        // Retrieve transactionReference for Mollie gateway.
        if (!isset($data['id']) && isset($_SESSION['omnipay_trans_ref'])) {
            // Retrieve transactionreference out of session. We need this to
            // reference our transaction status with our event. Destroy after.
            $data['id'] = $_SESSION['omnipay_trans_ref'];
            unset($_SESSION['omnipay_trans_ref']);
        }

        if (empty($data['id'])) {
            throw new InvalidRequestException("The transactionReference parameter is required");
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/payments/' . $data['id']);

        return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
    }
}
