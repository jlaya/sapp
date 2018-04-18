
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/general.css'); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Correo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<style type="text/css" media="screen">
		.avatar {
			/* cambia estos dos valores para definir el tamaño de tu círculo */
			height: 100px;
			width: 100px;
			/* los siguientes valores son independientes del tamaño del círculo */
			background-repeat: no-repeat;
			background-position: 50%;
			border-radius: 50%;
			background-size: 100% auto;
		}
	</style>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 10px 0 30px 0;">

				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<div class="notification">
								<?php echo $name; ?>
							</div>
							<!--<img src="http://sapp.bva.org.ve/assets/image/email.png" alt="Creating Email Magic" width="300" height="230" style="display: block;" />-->
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<?php echo $respuesta; ?>
									</td>
								</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="right" width="25%">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
												<a href="#" style="color: #ffffff;">
													<img class="avatar" src="http://sapp.bva.org.ve/assets/image/Home.png" alt="Sistema Automatizado para la Planificación y Presupuesto" width="50" height="50" style="display: block;" border="0" />
												</a>
											</td>
											<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>

										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
