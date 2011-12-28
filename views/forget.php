<?php /* @var $model ForgetPasswordForm */ ?>
<h3>Remember forgotten password</h3>
<?php echo get_notification() ?>
<div class="form">
	<form action="/index.php?action=forget" method="POST">
		<input type="hidden" name="do" value="confirm">
		<div class="row">
			<label for="email">Your e-mail:</label>
			<?php echo Html::input('text', 'email', $model->email); ?>
		</div>
		<div class="row">
			<label for="security_question">Security question:</label>
			<?php
				$options = array_combine($GLOBALS['q'], $GLOBALS['q']);
				echo Html::select('security_question', $options, $model->security_question)
			?>
		</div>
		<div class="row">
			<label for="security_answer">Answer:</label>
			<?php echo Html::input('text', 'security_answer', $model->security_answer); ?>
		</div>
		<div class="row">
			<?php echo Html::submit('Remind'); ?>
		</div>

	</form>
</div>