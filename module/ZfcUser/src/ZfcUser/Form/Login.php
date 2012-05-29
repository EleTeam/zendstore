<?php

namespace ZfcUser\Form;

use Zend\Form\Form,
    ZfcBase\Form\ProvidesEventsForm,
    ZfcUser\Module as ZfcUser;

class Login extends ProvidesEventsForm
{
    public function init()
    {
        $this->setMethod('post')
             ->loadDefaultDecorators()
             ->setDecorators(array('FormErrors') + $this->getDecorators());

        $this->addElement('text', 'identity', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            ),
            'required'   => true,
            'label'      => 'Email',
        ));
        

        if (ZfcUser::getOption('enable_username')) {
            $emailElement = $this->getElement('identity');
            $emailElement->removeValidator('EmailAddress')
                         ->setLabel('Email or Username'); // @TODO: make translation-friendly
        }
        
        $this->addElement('password', 'credential', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(6, 999))
            ),
            'required'   => true,
            'label'      => 'Password',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore'     => true,
            'decorators' => array('ViewHelper'),
        ));

        $this->addElement('submit', 'login', array(
            'ignore'   => true,
            'label'    => 'Sign In',
        ));

        $this->events()->trigger('init', $this);
    }
}
