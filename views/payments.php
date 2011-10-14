<?php 

$payments = Pronamic_WordPress_IDeal_PaymentsRepository::getPayments();

?>
<div class="wrap">
	<?php screen_icon(Pronamic_WordPress_IDeal_Plugin::SLUG); ?>

	<h2>
		<?php _e('iDEAL Payments', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN); ?>
	</h2>

	<form method="post" action="">
		<div class="tablenav top">
			<div class="alignleft actions">
				<select name="action">
					<option value="-1" selected="selected"><?php _e('Bulk Actions', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN); ?></option>
					<option value="delete"><?php _e('Delete', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN); ?></option>
				</select>

				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN); ?>"  />
			</div>
		</div>

		<table cellspacing="0" class="widefat fixed">

			<?php foreach(array('thead', 'tfoot') as $tag): ?>

			<<?php echo $tag; ?>>
				<tr>
					<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
					<th scope="col" class="manage-column"><?php _e('Date', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
					<th scope="col" class="manage-column"><?php _e('Transaction ID', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
					<th scope="col" class="manage-column"><?php _e('Description', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
					<th scope="col" class="manage-column"><?php _e('Consumer', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
					<th scope="col" class="manage-column"><?php _e('Amount', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
					<th scope="col" class="manage-column"><?php _e('Source', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
					<th scope="col" class="manage-column"><?php _e('Status', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN) ?></th>
				</tr>
			</<?php echo $tag; ?>>

			<?php endforeach; ?>

			<tbody>
				<?php foreach($payments as $payment): ?>

				<tr>
					<?php $transaction = $payment->transaction; ?>
					<th scope="row" class="check-column">
						<input type="checkbox" name="payments[]" value="<?php echo $payment->getId(); ?>"/>
					</th>
					<td>
						<?php 
						
						$detailsLink = Pronamic_WordPress_IDeal_Admin::getPaymentDetailsLink($payment->getId()); 

						$date = $payment->getDate();

						$timezone = get_option('timezone_string');
						if($timezone) {
							$date = clone $date;
							$date->setTimezone(new DateTimeZone($timezone));
						}
						
						?>
						<a href="<?php echo $detailsLink; ?>" title="<?php _e('Details', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN); ?>">
							<?php echo $date->format('d-m-Y @ H:i'); ?> 
						</a>
					</td>
					<td>
						<a href="<?php echo $detailsLink; ?>" title="<?php _e('Details', Pronamic_WordPress_IDeal_Plugin::TEXT_DOMAIN); ?>">
							<?php echo $transaction->getId(); ?>
						</a>
					</td>
					<td>
						<?php echo $transaction->getDescription(); ?>
					</td>
					<td>
						<?php echo $transaction->getConsumerName(); ?><br />
						<?php echo $transaction->getConsumerAccountNumber(); ?><br />
						<?php echo $transaction->getConsumerCity(); ?>
					</td>
					<td>
						<?php echo $transaction->getAmount(); ?>
						<?php echo $transaction->getCurrency(); ?>
					</td>
					<td>
						<?php 
						
						$text = $payment->getSource() . '<br />' . $payment->getSourceId();
						$text = apply_filters('pronamic_ideal_source_column_' . $payment->getSource(), $text, $payment);
						$text = apply_filters('pronamic_ideal_source_column', $text, $payment);
						
						echo $text;
						
						?>
					</td>
					<td>
						<?php echo Pronamic_WordPress_IDeal_IDeal::translateStatus($transaction->getStatus()); ?>
					</td>
				</tr>

				<?php endforeach; ?>
			</tbody>
		</table>
	</form>
</div>