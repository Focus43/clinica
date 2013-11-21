<?php defined('C5_EXECUTE') or die("Access Denied.");
/** @var $transaction ClinicaTransaction */

$subject = t("Clinica.org %s Receipt", $transaction->getTypeHandle(true));

$dateObj = new DateTime( $transaction->getDateCreated(), new DateTimeZone('UTC') );
$dateObj->setTimezone(new DateTimeZone('America/Denver'));
$paymentDate = $dateObj->format('M d, Y g:i a ') . ' America/Denver';

$payersName     = $transaction->__toString();
$payersAddress  = $transaction->getAddressString();
$patientName    = $transaction->getAttribute('patient_first_name') . ' ' . $transaction->getAttribute('patient_last_name');
$patientAccount = $transaction->getAttribute('clinica_account_number');
$paymentAmount  = number_format($transaction->getAmount(), 2);
$transactionID  = $transaction->getAuthNetTransactionID(); // the *AUTHORIZE.NET* transaction ID
$message        = $transaction->getMessage();

$logoSrc = BASE_URL . CLINICA_IMAGES_URL . '/logo_transparent.png';

$template = <<< heredoc
<html>
	<head>
		<title>Clinica.org Receipt</title>
		<style type="text/css">
			body {margin:0;padding:0;font-family:Arial;font-size:13px;font-weight:normal;line-height:120%;}
			body {-webkit-text-size-adjust:none;}
			table td {border-collapse:collapse;}
			h1, .h1 {padding-top:0;padding-bottom:10px;font-family:Arial;font-size:22px;font-weight:normal;line-height:100%;}
			p, .p {font-size:12px;line-height:130%;}
			blockquote, .blockquote {font-size:14px;}
		</style>
	</head>
	<body style="background-color:#f5f5f5;" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<center>
			<br /><br />
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="height:100% !important;margin:0;padding:0;width:100% !important;">
				<tr>
					<td valign="top">
						<center>
							<h1 class="h1">Clinica.org {$transaction->getTypeHandle(true)} Receipt</h1>
							<table cellpadding="0" cellspacing="0" width="600" style="background-color:#fff;border:1px solid #ccc;">
								<tr>
									<td valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="600">
											<tr>
												<td>
													<p class="p"><strong>Payer Name:</strong> {$payersName}</p>
													<p class="p"><strong>Payer Address:</strong> {$payersAddress}</p>
													<hr>
													<p class="p"><strong>Patient Name:</strong> {$patientName}</p>
													<p class="p"><strong>Patient Account #:</strong> {$patientAccount}</p>
													<hr>
													<p class="p"><strong>Payment Date:</strong> {$paymentDate}</p>
													<p class="p"><strong>Amount:</strong> &#36;{$paymentAmount}</p>
													<p class="p"><strong>Transaction ID:</strong> {$transactionID}</p>
													<hr>
													<p class="p"><strong>Message From Sender:</strong> {$message}</p>
													<hr>
												</td>
											</tr>
											<tr>
											    <td>
											        <table cellpadding="0" cellspacing="0" border="0">
											            <tr>
											                <td>
                                                                <p><strong>Clinica Family Health Services</strong></p>
                                                                <p>1345 Plaza Court North, 1A<br>Lafayette, CO 80026<br>Phone: (303) 650-4460</p>
                                                                <p>{$logoSrc}</p>
													        </td>
											                <td style="text-align:right;"><img src="{$logoSrc}" alt="Clinica Logo" /></td>
											            </tr>
											        </table>
											    </td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</center>
					</td>
				</tr>
			</table>
			<br /><br />
		</center>
	</body>
</html>
heredoc;

$bodyHTML = t($template);
