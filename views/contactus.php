<h3>Contact us</h3>
<?php echo get_notification() ?>
<div class="form">
	<form action="/index.php?action=contactus" method="POST">
		<input type="hidden" name="do" value="send" />
		<div class="row">
			<label for="from">From:</label>
			<?php echo Html::input('text', 'from', $model->from); ?>
			<span class="error"><?php echo $model->getError('from'); ?></span>
		</div>
		<div class="row">
			<label for="subject">Subject:</label>
			<?php echo Html::input('text', 'subject', $model->subject); ?>
			<span class="error"><?php echo $model->getError('subject'); ?></span>
		</div>
		<div class="row">
			<label for="message">Message:</label>
			<textarea name="message" id="message" cols="30" rows="5"></textarea>
			<span class="error"><?php echo $model->getError('message'); ?></span>
		</div>
		<?php if (CAPTCHA_ENABLED) : ?>
		<div class="row">
			<label for="captcha">Enter CAPTCHA:</label>
			<?php echo Html::captcha(); ?>
			<span class="error"><?php echo $model->getError('captcha'); ?></span>
		</div>
		<?php endif; ?>
		<div class="row">
			<input type="submit" value="Send" />
		</div>

	</form>
</div>