<?php
namespace FileUpload\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;

class SingleUpload extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->setInputFilter($this->createInputFilter());
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('file');
        $file
            ->setLabel('File Input')
            ->setAttributes(array(
                'id' => 'file',
                'class' => 'form-control'
            ));
        $this->add($file);
        
        $this->add(array(     
            'type' => 'Zend\Form\Element\Hidden',       
            'name' => 'id',
        ));
        
        $this->add(array(     
            'type' => 'Zend\Form\Element\Select',       
            'name' => 'file_type',
            'attributes' =>  array(
                'id' => 'file_type',                
                'options' => \Application\Form\OptionsConfig::getFormOption('file_upload_type'),
                'class' => 'form-control',
                'required' => true,
            ),
            'options' => array(
                'label' => 'Datei-Typ',
            ),
        ));
    }

    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $file = new InputFilter\FileInput('file');
        $file->setRequired(true);
        $file->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'          => './data/file-upload-temp/',
                'overwrite'       => true,
                'use_upload_name' => true,
            )
        );
        $inputFilter->add($file);


        $text = new InputFilter\Input('file_type');
        $text->setRequired(true);
        $inputFilter->add($text);

        return $inputFilter;
    }
}