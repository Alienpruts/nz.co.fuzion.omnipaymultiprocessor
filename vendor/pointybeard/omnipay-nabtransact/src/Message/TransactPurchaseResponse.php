<?php

namespace Omnipay\NABTransact\Message;

class TransactPurchaseResponse extends TransactAbstractResponse
{
    public function isRedirect()
    {
        return false;
    }

    public function isSuccessful()
    {
        return ($this->getStatusCode() == 0 && $this->getCode() == '00');
    }

    public function getMessageId()
    {
        return $this->getMessageInfo()['messageID'];
    }

    public function getMessageInfo()
    {
        return (array) $this->data->MessageInfo;
    }

    public function getStatusCode()
    {
        return (int) $this->data->Status->statusCode;
    }

    public function getMessage()
    {
        return (string) $this->data->Payment->TxnList->Txn->responseText;
    }

    public function getCode()
    {
        return (string) $this->data->Payment->TxnList->Txn->responseCode;
    }
}
