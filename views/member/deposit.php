<h3>Make deposit</h3>
<p><?php echo get_notification(); ?></p>
<div class="form">
	<form action="member.php?action=deposit" method="post">
		<input type="hidden" name="do" value="deposit"/>
		<?php
		/* @var $model DepositForm */
		if (count($model->plans)) {
			?>
			<p><span class="error"><?php echo $model->getError('plan_id'); ?></span></p>
			<table width="100%">
				<tr>
					<th></th>
					<th>Description</th>
					<th>Min - Max</th>
					<th>Profit</th>
				</tr>
				<?php
				/**
				 * Used in javascript Calculator
				 */
				$plan_select_options = array();
				foreach ($model->plans as $key => $plan) {
					$plan_select_options[$plan->id] = $plan->name;
					?>
					<tr>
						<td valign="top"
						    align="center"><?php echo Html::input('radio', 'plan_id', $plan->id,
							$key == 0 || $plan->id == $model->plan_id ? array('checked' => 'checked') : array()); ?>
						</td>
						<!-- Description -->
						<td>
							<strong><?php echo h($plan->name); ?></strong><br>
							<?php echo h($plan->description); ?>
							<div class="hint">
								<?php
								echo '<b>Accurals periodicity:</b> ' . time2str($plan->periodicity) . '<br>';
								echo '<b>Working days:</b> ' . ($plan->monfri ? 'Monday - Friday' : 'Monday - Sunday')
									. '<br>';
								echo '<b>Compounding:</b> ' . ($plan->compounding ? 'yes' : 'no') . '<br>';
								echo '<b>Principal return:</b> ' . ($plan->principal_back ? 'yes' : 'no');
								?>
							</div>
						</td>
						<!-- Min-Max -->
						<td nowrap="nowrap" align="center">
							$<?php echo number_format($plan->min) . ' &mdash; $' . number_format($plan->max); ?></td>
						<!-- Profit -->
						<td align="center">
							<?php
							echo $plan->percent . '%';
							if ($plan->percent_per == 'term')
								echo ' after ' . time2str($plan->term);
							else
								echo ' every ' . time2str($plan->periodicity);
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
			<?php
		}
		?>
		<br><br>

		<div style="float:left;margin-right: 20px;">
			<div class="row">
				<label for="source">Source:</label>
				<?php
				$sources = $GLOBALS['ecurrencies'];
				$sources['BALANCE'] = 'Available balance ($' . number_format(App::get()->member->balance, 2) . ')';
				echo Html::select('source', $sources, $model->source);
				?>
				<span class="error"><?php echo $model->getError('source'); ?></span>
			</div>
			<div class="row">
				<label for="amount">Amount:</label>
				<?php echo Html::input('text', 'amount', $model->amount); ?>
				[<a href="#" onclick="$('#calculator').dialog('open')">Calculator</a>]
				<span class="error"><?php echo $model->getError('amount'); ?></span>
			</div>
			<div class="row">
				<?php echo Html::submit('Make deposit'); ?>
			</div>
		</div>
		<div style="float:left;">
			<?php if (CAPTCHA_ENABLED) : ?>
			<div class="row">
				<label for="captcha">Enter CAPTCHA:</label>
				<?php echo Html::captcha(); ?>
				<span class="error"><?php echo $model->getError('captcha'); ?></span>
			</div>
			<?php endif; ?>
		</div>
	</form>
</div>
<div id="calculator">
	<div class="form">
		<form>
			<div class="row">
				<label for="calc_plan">Plan:</label>
				<?php
				$plan_select_options = array('' => 'Select plan') + $plan_select_options;
				echo Html::select('calc_plan', $plan_select_options, '');
				?>
			</div>
			<div class="row">
				<label for="calc_amount">Amount ($):</label>
				<?php echo Html::input('text', 'calc_amount', 0, array('maxlength'=> 6,
				                                                      'size'      => 6)); ?>
			</div>
			<div class="row" id="calc_compounding_row" style="display:none;">
				<label for="calc_compounding">Reinvest (%):</label>
				<?php echo Html::input('text', 'calc_compounding', 100, array('style'   => 'float: left;',
				                                                             'maxlength'=> 3,
				                                                             'size'     => 6
				                                                        )); ?>
				<div id="calc_compounding_slider" style="float: right;margin:10px 30px 0 0;width:220px;"></div>
			</div>
		</form>
	</div>
	Result: <span id="calc_result" class="error">0</span>
</div>
<script type="text/javascript" language="JavaScript" src="js/calculator.js"></script>
<script type="text/javascript" language="JavaScript">
	<?php
	$plans_js = array();
	foreach ($model->plans as $plan) {
		$plans_js[] = "\n"  . intval($plan->id) . ' : { min: ' . floatval($plan->min) . ', max: '
			. floatval($plan->max) . ', percent: ' . floatval($plan->percent) . ', percent_per: '
			. q($plan->percent_per) . ', periodicity: ' . intval($plan->periodicity) . ', term: '
			. intval($plan->term) . ', compounding: ' . var_export((bool)$plan->compounding, true)
			. ', principal_back: ' . var_export((bool)$plan->principal_back, true) . ', monfri: '
			. var_export((bool)$plan->monfri, true) . ' }';
	}

	?>
	var Plans = {<?php echo implode(',', $plans_js); ?>};
	$(function () {
		$("#calculator").dialog({
			title:"Calculator",
			autoOpen:false,
			height:360,
			width:400,
			modal:true,
			closeOnEscape:true,
			buttons:{
				"Calculate":function () {
					var now = <?php echo App::get()->now ?>;
					var calc_plan = Plans[$('#calc_plan').val()];
					var calc_amount = $('#calc_amount').val();
					var calc_compounding = $('#calc_compounding').val();
					$("#calc_result").html(Calculator.getResult(now, calc_plan, calc_amount, calc_compounding));
				},
				"Close":function () {
					$(this).dialog("close");
				}
			},
			open:function (event, ui) {

			}
		});
		$("#calc_plan").change(function () {
			if (Plans[$(this).val()].compounding == "1")
				$("#calc_compounding_row").show();
			else
				$("#calc_compounding_row").hide();
		});
		$("#calc_compounding_slider").slider({
			value:100,
			min:0,
			max:100,
			step:1,
			slide:function (event, ui) {
				$("#calc_compounding").val(ui.value);
			}
		});
		$("#calc_compounding").val($("#calc_compounding_slider").slider("value"));
		$("#calc_compounding").keyup(function () {
			$("#calc_compounding_slider").slider("value", parseInt($(this).val()));
		});
	});
</script>
