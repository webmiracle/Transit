<?php
class Dev_Callback_IndexController extends Mage_Core_Controller_Front_Action
{

    public function sentAction()
    {
        if (!$this->getRequest()->getParam('is_ajax')) {
            $this->norouteAction();
        }

        $post  = $this->getRequest()->getParams();
        if (isset($post['cbfirstname']) && isset($post['cblastname'])&&
            isset($post['cbphone']) && isset($post['cbquestion'])
            && $email  =  Mage::getStoreConfig('trans_email/ident_general/email')

        ) {

            $emailTemplate  = Mage::getModel('core/email_template')
                ->loadDefault('callback_email_template');

            $processedTemplate = $emailTemplate->getProcessedTemplate($post);
            $emailTemplate->setSenderName($post['cbfirstname']);
            $emailTemplate->setSenderEmail('callback@form');
            $emailTemplate->setTemplateSubject('Callback');
            $emailTemplate->send($email,'Name To', $post);
        }
    }













}
