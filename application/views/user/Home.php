<?php
$titulo       = $this->session->userdata['logged_in']['titulo'];
$avatar       = $this->session->userdata['logged_in']['avatar'];
$ver = $this->session->userdata['logged_in']['ver'];
echo "HOLA: ".$ver;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<body>
	<div>
		
		<?php if($ver == "t"){ ?>
			<!--<object type="application/php" data='<?php echo base_url("gestion/panel");?>' style="width:100%; height:600px;"></object>-->
			
			<object type="application/php" data="<?php echo base_url("gestion/panel");?>"  style="width:100%; height:600px;">
			  <embed src="<?php echo base_url("gestion/panel");?>"  style="width:100%; height:600px;" frameborder="0" style="border:0;">
			</object>
			
		<?php }else{ ?>
			<img title="<?php echo $titulo; ?>" style="width: 53%; margin:30px;margin-left: 25%; cursor: pointer;" src="<?php echo base_url("assets/foto/$avatar"); ?>"/>
		<?php } ?>
	</div>
</body>
</html>
