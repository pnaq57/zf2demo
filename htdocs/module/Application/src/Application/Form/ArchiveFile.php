<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;


use Zend\Form\Form;

/**
 * Customer form
 * 
 * Form for the customer
 * 
 * @package    Customer
 */
class ArchiveFile extends Form
{
    /**
     * Build form
     */
    public function init()
    {
        $this->setName('customer_form');
        
        $this->add(array(
            'type' => 'Csrf',
            'name' => 'csrf',
        ));
        
        $this->add(array(
            'type'       => 'Text',
            'name'       => 'firstname',
            'options'    => array(
                'label'  => 'Vorname',
            ),
            'attributes' => array(
                'class'  => 'span5',
            ),
        ));
        
        $this->add(array(
            'type'       => 'Text',
            'name'       => 'lastname',
            'options'    => array(
                'label'  => 'Nachname',
            ),
            'attributes' => array(
                'class'  => 'span5',
            ),
        ));
        
        
        $this->add(array(
            'type'       => 'Customer\CustomerAddressFieldset',
            'name'       => 'address',
        ));

        $this->add(array(
            'type'       => 'Select',
            'name'       => 'country',
            'options'    => array(
                'label'  => 'Land',
                'value_options' => array(
                    1 => 'Deutschland', 2 => 'Österreich', 3 => 'Schweiz',
                ),
            ),
            'attributes' => array(
                'class'  => 'span5',
            ),
        ));
        
        $this->add(array(
            'type'       => 'Submit',
            'name'       => 'save',
            'options'    => array(
            ),
            'attributes' => array(
                'value'  => 'Speichern',
                'id'     => 'save',
                'class'  => 'btn btn-primary',
            ),
        ));
    }
}
