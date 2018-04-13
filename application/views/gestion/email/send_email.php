
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

				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<div class="notification">
								Gestión de Control
							</div>
							<img src="http://sapp.bva.org.ve/assets/image/email.png" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							    <tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>ID: </b>
										<a href='<?php echo base_url("acciones/registro/ControllersRegistro/procesar_list/$codigo"); ?>'>
											<?php echo $codigo; ?>
										</a>
										<br/><br/>
									</td>
								</tr>
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b><?php echo $this->session->userdata['logged_in']['nom_ins']; ?></b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;text-align: justify;">
										La información a sido reportada a la Dirección de Planificación y Presupuesto, bajo las siguientes especificaciones, considerando
										que la información contenida es de responsabilidad directa del emisor y que una vez
										que alla sido reportada no puede ser manipulado por ninguna razón agena a su voluntad.
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;text-align: justify;">
										<div class='info-email'>
											<ul>
												<li><span class='bold-span'>Cumplido: </span>(<?php echo $count_cumplido_acc->cumplido; ?>)</li>
												<li><span class='bold-span'>No cumplido: </span>(<?php echo $count_no_cumplido_acc->no_cumplido; ?>)</li>
											</ul>
										</div>
										<br/>
										<fieldset>
											<legend class="bold">EJECUCIÓN FISICA</legend>
											<table class="table striped separator" border="1">
												<thead>
													<tr class="align-center">
														<th class="align-center">#</th>
														<th class="align-center">Actividad</th>
														<th class="th">Programado</th>
														<th class="th">Cumplido</th>
														<th class="align-center space">%</th>
														<th class="th">Programada</th>
														<th class="th">Ejecutada</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1;  foreach ($accion as $row) { ?>
													<tr>
														<td style="background-color: #7F7F7F; color: #FFFFFF;"><?php echo $i; ?></td>
														<td><?php echo $row->actividad; ?></td>
														<td class="align-right" style="text-align:right;"><?php echo $this->pdf->Format_number($row->prog_trimestral) ?></td>
														<td class="align-right" style="text-align:right;"><?php echo $this->pdf->Format_number($row->cump_trimestral) ?></td>
														<td class='align-center' style="text-align: center;">
															<?php if ($row->cump_trimestral != 0 or $row->prog_trimestral != 0){  ?>
															<span><?php echo ($row->cump_trimestral/$row->prog_trimestral)*100 ?>%</span>
															<?php }else{ ?>
															0.00%
															<?php } ?>
														</td>
														<td class="align-right" style="text-align:right;"><?php echo $this->pdf->Format_number($row->meta_programado); ?></td>
														<td class="align-right" style="text-align:right;"><?php echo $this->pdf->Format_number($row->meta_ejecutado); ?></td>
													</tr>
													<?php $i++; } ?>
												</tbody>
											</table>
										</fieldset>
										<br/>
										<br/>
										<fieldset>
											<legend class="bold">EJECUCIÓN FINANCIERA</legend>
											<table class="table striped separator" border="1">
												<thead>
													<tr class="align-center">
														<th class="align-center">#</th>
														<th class="align-center">Partida Presupuestaria</th>
														<th class="th">Compromiso</th>
														<th class="th">Causado</th>
														<th class="th">Pagado</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i              = 1;
													$sum_compromiso = 0;
													$sum_causado    = 0;
													$sum_pagado     = 0;

													foreach ($financiero as $row) { ?>
													<tr>
														<td style="background-color: #7F7F7F; color: #FFFFFF;"><?php echo $i; ?></td>
														<td><?php echo $row->partida; ?></td>
														<td class="align-right" style="text-align:right;"><?php echo $this->pdf->Format_number($row->compromiso); ?></td>
														<td class="align-right" style="text-align:right;"><?php echo $this->pdf->Format_number($row->causado); ?></td>
														<td class='align-center' style="text-align:right;"><?php echo $this->pdf->Format_number($row->pagado); ?></td>
													</tr>
													<?php
													$sum_compromiso = $sum_compromiso + $row->compromiso;
													$sum_causado    = $sum_causado + $row->causado;
													$sum_pagado     = $sum_pagado + $row->pagado;
													$i++;

												}

												?>
												<tr>
													<td style="background-color: #7F7F7F; color: #FFFFFF;"></td>
													<td></td>
													<td class="align-right" style='font-weight: bold; text-align: right;'><?php echo $this->pdf->Format_number($sum_compromiso); ?></td>
													<td class="align-right" style='font-weight: bold; text-align: right;'><?php echo $this->pdf->Format_number($sum_causado); ?></td>
													<td class='align-center' style='font-weight: bold; text-align: right;'><?php echo $this->pdf->Format_number($sum_pagado); ?></td>
												</tr>
											</tbody>
										</table>
									</fieldset>

								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
									&reg; Sistema Automatizado para la Planificación y Presupuesto<br/>
									<a target="_blank" href="<?php echo base_url('/gestion');?>" title='Regresar' style="color: #ffffff;"><font color="#ffffff">SAPP</font></a> <?php echo date('Y', now());?>
								</td>
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