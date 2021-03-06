<?php

class App_Form_CrearContacto extends App_Form
{
    public function init() {
        parent::init();
        
        $e = new Zend_Form_Element_Text('idContacto');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        // name
        $e = new Zend_Form_Element_Text('nombre');
        $e->setLabel('Nombre');
        $e->setAttrib('size', '40');
        $e->setAttrib('class', 'required');
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);

        // lastname
        $e = new Zend_Form_Element_Text('apellido');
        $e->setLabel('Apellidos');
         $e->setAttrib('size', '40');
        $e->setAttrib('class', 'required');
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);
        
        // usuario
         $e = new Zend_Form_Element_Text('email');
         $e->setAttrib('size', '40');
        $e->setAttrib('class', 'required email');
        $e->setFilters(array("StripTags", "StringTrim"));
        $v = new Zend_Validate_EmailAddress();
        $e->addValidator($v);
        $e->setRequired(true);
        $e->addFilter(new Zend_Filter_HtmlEntities());
        $this->addElement($e);
        
        
        // telefono
        $e = new Zend_Form_Element_Text('telefono');
        $e->setAttrib('class', 'required number');
        $e->setAttrib('minlength', '8');
        $e->setAttrib('maxlength', '10');
        
        $v = new Zend_Validate_StringLength(array('min'=>8,'max'=>10));
        $e->addValidator($v);
        $this->addElement($e);
        
        //cargo
        $e = new Zend_Form_Element_Text('cargo');
         $e->setAttrib('size', '40');
        $v = new Zend_Validate_StringLength(array('max'=>50));
        $e->addValidator($v);
        $this->addElement($e);
        
        // submit
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar');
        $e->setAttrib('class', 'btn primary');
        $this->addElement($e);
        
        $this->addElement('hash', 'csrf');
        
         foreach($this->getElements() as $e) {
            $e->removeDecorator('DtDdWrapper');
            $e->removeDecorator('Label');
            $e->removeDecorator('HtmlTag');
        } 
    }
}

?>
