<?php
/* @var $this \C\View\ConcreteContext */
/* @var $form \Symfony\Component\Form\FormView */
?>

Some data..


<?php
echo $this->form_start($myForm);
echo $this->form_row($myForm['email'], ['type'=>'email']);
echo $this->submit_widget($myForm['save'], ['label'=>'button.save']);
echo $this->form_end($myForm);
?>