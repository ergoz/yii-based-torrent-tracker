<?php
/**
 * @var TbActiveForm $form
 */
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',
	array(
	     'id'                     => 'login-form',
	     'enableAjaxValidation'   => true,
	     'enableClientValidation' => true,
	     'action'                 => Yii::app()->createUrl('/user/default/login'),
	     'clientOptions'          => array(
		     'validateOnSubmit' => true,
	     ),
	)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5')); ?>

<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span5')); ?>

<?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',
			array(
			     'buttonType' => 'submit',
			     'type'       => 'primary',
			     'label'      => 'Login',
			)); ?>
	</div>

<?php $this->endWidget(); ?>
