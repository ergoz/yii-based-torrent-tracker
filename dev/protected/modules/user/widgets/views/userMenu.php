<?php
if ( Yii::app()->getUser()->getIsGuest() ) {

	$this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'loginModal')); ?>

	<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo Yii::t('userModule.common', 'Login'); ?></h4>
	</div>

	<div class="modal-body">
		<?php Yii::app()->getController()->renderPartial('application.modules.user.views.default.login',
			array('model' => $loginModel)); ?>
	</div>

	<?php $this->endWidget();

	$this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'registerModal')); ?>
	<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo Yii::t('userModule.common', 'Register'); ?></h4>
	</div>

	<div class="modal-body">
	<?php Yii::app()->getController()->renderPartial('application.modules.user.views.default.register',
			array(
			     'model' => $registerModel,
			)); ?>
	</div>
	<?php $this->endWidget();


}