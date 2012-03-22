<?php 

if(!empty($_POST) && check_admin_referer('pronamic_ideal_save_settings', 'pronamic_ideal_nonce')) {
	$key = filter_input(INPUT_POST, 'pronamic_ideal_key', FILTER_SANITIZE_STRING);

	Pronamic_WordPress_IDeal_Plugin::setKey($key);
}

?>
<div class="wrap">
	<?php screen_icon(Pronamic_WordPress_IDeal_Plugin::SLUG); ?>

	<h2>
		<?php _e('iDEAL Settings', 'pronamic_ideal'); ?>
	</h2>

	<form action="" method="post">
		<?php wp_nonce_field('pronamic_ideal_save_settings', 'pronamic_ideal_nonce'); ?>

		<h3>
			<?php _e('General Settings', 'pronamic_ideal'); ?>
		</h3>

		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="pronamic_ideal_key">
						<?php _e('Support License Key', 'pronamic_ideal'); ?>
					</label>
				</th>
				<td>
	                <input id="pronamic_ideal_key" name="pronamic_ideal_key" value="<?php echo Pronamic_WordPress_IDeal_Plugin::getKey(); ?>" class="regular-text" type="password" />

					<?php if(Pronamic_WordPress_IDeal_Plugin::hasValidKey()): ?>
					&#10003;
					<?php endif; ?>

					<span class="description">
						<br />
						<?php _e('The license key is used for access to automatic upgrades and support.', 'pronamic_ideal'); ?>
					</span>
				</td>
			</tr>
		</table>

		<h3>
			<?php _e('Installation Status', 'pronamic_ideal'); ?>
		</h3>

		<?php global $wpdb; ?>

		<table class="form-table">
			<tr>
				<th scope="row">
					<?php _e('PHP Version', 'pronamic_ideal'); ?>
				</th>
				<td class="column-version">
	                <?php echo phpversion(); ?>
				</td>
				<td>
					<?php 
					
					if(version_compare(phpversion(), '5.2', '>')) {
						echo '&#10003;';
					} else {
						_e('Pronamic iDEAL requires PHP 5.2 or above.', 'pronamic_ideal');
					}
					
					?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e('MySQL Version', 'pronamic_ideal'); ?>
				</th>
				<td class="column-version">
	                <?php echo $wpdb->db_version(); ?>
				</td>
				<td>
					<?php 

					if(version_compare($wpdb->db_version(), '5', '>')) {
						echo '&#10003;';
					} else {
						_e('Pronamic iDEAL requires MySQL 5 or above.', 'pronamic_ideal');
					}

					?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e('WordPress Version', 'pronamic_ideal'); ?>
				</th>
				<td class="column-version">
	                <?php echo get_bloginfo('version'); ?>
				</td>
				<td>
					<?php 
					
					if(version_compare(get_bloginfo('version'), '3.2', '>')) {
						echo '&#10003;';
					} else {
						_e('Pronamic iDEAL requires WordPress 3.2 or above.', 'pronamic_ideal');
					}
					
					?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e('Time', 'pronamic_ideal'); ?>
				</th>
				<td class="column-version">
	                <?php echo date(__('Y/m/d g:i:s A', 'pronamic_ideal')); ?><br />
	                <?php echo date(Pronamic_IDeal_IDeal::DATE_FORMAT); ?>
				</td>
			</tr>
		</table>

		<?php 
		
		submit_button(
			empty($configuration->id) ? __('Save', 'pronamic_ideal') : __('Update', 'pronamic_ideal') , 
			'primary' ,
			'save_settings'
		);

		?>
	</form>
</div>