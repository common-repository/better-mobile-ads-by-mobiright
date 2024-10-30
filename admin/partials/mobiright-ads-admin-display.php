<?php

$root_domain      = site_url();
$user_info_option = get_option( 'mobiright_user_info' );
$user_info        = array();
$config           = mobiright_get_config();

if ( $user_info_option ) {
	$user_info = unserialize( $user_info_option );
}
$get_request = wp_remote_get( $config['server'] . '/' . urlencode( $root_domain ) . '?active=' . $user_info['status'] . '&format=' . $user_info['ad_format'] );
if ( is_wp_error( $get_request ) ) {
	$status = 'getError';
} else {
	$data   = json_decode( $get_request['body'] );
	$status = $data->status;
}

$statuses = array(
	'Active'          => 'Active',
	'PendingApproval' => 'Pending Approval',
	'InActive'        => 'Inactive',
	'getError'        => 'Error retrieving status, Please try again later',
	'saveError'       => '* There was an error saving your changes, Please try again'
);

?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Better Mobile Ads by Mobiright</title>
</head>
<body id="mobiright">

<h1>Better Mobile Ads by <strong>Mobiright</strong></h1>

<p>IMPORTANT NOTES:</p>
<ul>
	<li>* By adding the Better Mobile Ads by Mobiright plugin to your site you’re agreeing to the <a
			href="http://www.mobiright.com/publisher-terms-of-use.pdf">Terms of Use</a>.
	</li>
	<li>* Please note that the initial approval to run Mobiright Ads on your site and the approval of every change in
		the ad unit configuration afterward may take up to 48 hours.
	</li>
	<li>* For any questions please email us at <a href="mailto:support@mobiright.com">support@mobiright.com</a>.</li>
	<li>* Caching Plugin Users (WP Super Cache, W3 Total Cache, Wordfence Security, WP Rocket etc.): Clearing cache is
		required after saving any changes in Ad Unit Settings.
	</li>
</ul>
<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" id="mobi-form">
	<input type="hidden" name="action" value="mobiright_save">

	<h2 class="nav-tab-wrapper">
		<a href="#" class="nav-tab nav-tab-active">Ad Unit Settings</a>
		<a href="#" class="nav-tab">Account Information</a>
		<input class="button-primary save-btn" type="submit" name="save" value="Save Changes" id="save-btn"/>
		<span class="spinner"></span>
		<?php if ( $_GET['error'] ) { ?>
			<span style="color: red; font-size: 12px; font-weight: 100;"><?php echo $statuses['saveError'] ?></span>
		<?php } ?>
	</h2>

	<section class="tab" id="settings">
		<div class="form-row lg-text">
			<div class="form-col-1">
				<span class="form-title">Ad Activation:</span>
			</div>
			<div class="form-col-1">
				<input name="status" id="mobiright-status"
				       type="checkbox" <?php echo $status == 'Active' || $status == 'PendingApproval' ? 'checked' : '' ?>/>
			</div>
			<div class="form-col-3">
				<span>Status: </span>
				<span>
					<strong>
						<?php echo $statuses[ $status ] ?>
					</strong>
					<?php if ( $status == 'PendingApproval' ): ?>
						<small>(Once approved the ad will start showing on all pages of this domain automatically)
						</small>
					<?php endif; ?>
				</span>
			</div>

		</div>
		<div class="form-row lg-text">
			<div class="form-col-1">
				<span class="form-title">Ad Choices:</span>
			</div>
			<div class="form-col-3">
				<label class="radio-btn-container">
					<input type="radio" name="ad_format"
					       value="adaptive" <?php echo $user_info['ad_format'] ? ( $user_info['ad_format'] == "adaptive" ? 'checked' : '' ) : 'checked' ?>/>
					<span> <strong class="lg-text">Bottom Screen Docked Ad</strong></span>
					<img src="<?php echo plugins_url( 'better-mobile-ads-by-mobiright/admin/images/bottom.png' ) ?>"
					     alt=""/>
				</label>
			</div>
			<div class="form-col-3">

				<label class="radio-btn-container">
					<input type="radio" name="ad_format"
					       value="inpage" <?php echo $user_info['ad_format'] ? ( $user_info['ad_format'] == "inpage" ? 'checked' : '' ) : 'checked' ?>/>
				<span><strong class="lg-text">In-Page Ad</strong> <small>(Requires to manually place HTML tags within
						your theme code)
					</small></span>
					<img src="<?php echo plugins_url( 'better-mobile-ads-by-mobiright/admin/images/in-page.png' ) ?>"
					     alt=""/>
				</label>
			</div>
		</div>
	</section>
	<section class="tab" id="info" style="display: none;">
		<div class="form-row">
			<div class="form-col-4">
				<div class="form-col">
					<label for="fname">First Name:</label>
				</div>
				<input type="text" name="fname" id="fname" class="regular-text"
				       value="<?php echo $user_info['fname'] ?>"
					/>
			</div>
		</div>
		<div class="form-row">
			<div class="form-col-4">
				<div class="form-col">

					<label
						for="lname">Last
						Name:</label>
				</div>
				<input type="text" name="lname" id="lname" class="regular-text"
				       value="<?php echo $user_info['lname'] ?>"/>
			</div>
		</div>
		<div class="form-row">
			<div class="form-col-4">
				<div class="form-col">
					<label for="email">Email:</label>
				</div>
				<input type="email" name="email" id="email" class="regular-text"
				       value="<?php echo $user_info['email'] ?>"/>
			</div>
		</div>
		<div class="form-row">
			<div class="form-col-4">
				<div class="form-col">

					<label for="paypal">Paypal:</label>
				</div>
				<input type="text" name="paypal" id="paypal" class="regular-text"
				       value="<?php echo $user_info['paypal'] ?>"/>
			</div>
		</div>
		<p><strong>Payment terms:</strong></p>
		<ul>
			<li>
				* Revenue-share 80-20 (80% of all revenues goes to you), monthly payment (once a month),
				NET+30,
				minimum payment threshold of $50 USD.
			</li>
			<li>
				* Your monthly payments will occur automatically upon receiving a valid Paypal invoice at the Mobiright
				Paypal address: mobi@mobiright.com
			</li>
			<li>
				* If your balance is lower than the minimum payment threshold your funds will automatically be rolled
				on to
				the following month.
			</li>
		</ul>
	</section>
</form>

</body>
</html>
