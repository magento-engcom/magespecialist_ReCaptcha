<?php

namespace MSP\ReCaptcha\Model\Provider\Failure\RedirectUrl;

use MSP\ReCaptcha\Model\Provider\Failure\RedirectUrlProviderInterface;

class RefererProvider implements RedirectUrlProviderInterface
{
    protected $redirect;
    
    public function __construct(
        \Magento\Framework\App\Response\RedirectInterface $redirect
    ) {
        $this->redirect = $redirect;
    }

    public function execute()
    {
        return $this->redirect->getRedirectUrl();
    }
}
