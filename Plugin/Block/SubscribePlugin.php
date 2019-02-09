<?php
/**
 * MageSpecialist
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magespecialist.it so we can send you a copy immediately.
 *
 * @category   MSP
 * @package    MSP_ReCaptcha
 * @copyright  Copyright (c) 2017 Skeeller srl (http://www.magespecialist.it)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace MSP\ReCaptcha\Plugin\Block;

use DOMDocument;
use DOMNode;

/**
 * Class SubscribePlugin
 *
 * @package MSP\ReCaptcha\Plugin\Block
 */
class SubscribePlugin
{
    /**
     * @param \Magento\Newsletter\Block\Subscribe $subject
     * @param $result
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return string
     */
    public function afterToHtml($subject, $result) {
        $block = $subject->getLayout()->getBlock('msp-recaptcha-newsletter');
        
        if (!$block) {
            return $result;
        }
        
        $blockHtml = $block->toHtml();
        
        $subscribeBlockContent = new DOMDocument();
        $subscribeBlockContent->loadHTML($result);

        $recaptchaContent = new DOMDocument();
        $recaptchaContent->loadHTML($blockHtml);

        $form = $subscribeBlockContent->getElementsByTagName('form');
        $formNodes = [];

        if ($form) {
            foreach ($form as $formNode) {
                $formNodes[] = $formNode;
            }

            foreach ($recaptchaContent->getElementsByTagName('body')->item(0)->childNodes as $recaptchaChildNode) {
                $recaptchaChildNode = $subscribeBlockContent->importNode($recaptchaChildNode, true);
                
                if ($formNodes) {
                    $formNodes[0]->appendChild($recaptchaChildNode);
                }
            }

            return $subscribeBlockContent->saveHTML();
        }

        return $result;
    }
}
