<?php
$this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'loginModal')); ?>

<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo Yii::t('userModule.common', 'Login') ?></h4>
</div>

<div class="modal-body">
	<?php $this->renderPartial('application.modules.user.views.default.login'); ?>
</div>

<?php $this->endWidget(); ?>