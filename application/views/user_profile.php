<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Allo-voisins</title>

	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>


<?php //var_dump($user); exit; ?>	

<div id="body">
	<div class="container mt-5">
		<h2>Profile Update</h2>
		<?php echo validation_errors(); ?>
		<?php echo form_open('api/user/profile/' . $user->getId()); ?>
			<div class="mb-3">
				<label for="firstName" class="form-label">First Name</label>
				<input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo set_value('firstName', $user->getFirstName()); ?>">
			</div>
			<div class="mb-3">
				<label for="lastName" class="form-label">Last Name</label>
				<input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo set_value('lastName', $user->getLastName()); ?>">
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email', $user->getEmail()); ?>">
			</div>
			<div class="mb-3">
				<label for="phone" class="form-label">Phone</label>
				<input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone', $user->getPhone()); ?>">
			</div>
			<div class="mb-3">
				<label for="postalAddress" class="form-label">Postal Address</label>
				<textarea class="form-control" id="postalAddress" name="postalAddress"><?php echo set_value('postalAddress', $user->getPostalAddress()); ?></textarea>
			</div>
			<div class="mb-3">
				<label for="professionalStatus" class="form-label">Professional Status</label>
				<input type="text" class="form-control" id="professionalStatus" name="professionalStatus" value="<?php echo set_value('professionalStatus', $user->getProfessionalStatus()); ?>">
			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		<?php echo form_close(); ?>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
