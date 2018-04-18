<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
        .stepContainer{
            height: 500px !important;
        }

</style>

<div class="title_left">
    <h3>RESEÑAS</h3>
</div>


<div class="modal" id="modal_servicios">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                   
                    &nbsp;  Registrar Delito
                </h4>
            </div>
            <div class="modal-body">
                <form name="nuevo_delito" action="" method="post" class="form">

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="decision_tribunal">Decisión del tribunal</label>
                            <select id="decision_tribunal" name="decision_tribunal" style="width:100%" class="form-control" required>
                                <option value="0">Seleccione...</option>
                                <option value="1">Privativo de libertad</option>
                                <option value="2">Liberta Plena</option>
                                <option value="3">Medida cautelar sustitutiva de libertad</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">

                            <label for="delito_id">Delito o Falta* </label>
                            <select id="delito_id" class="form-control" style="width:100%" required>
                                <option value="0">Seleccione...</option>
                                <?php
                                foreach ($delito as $delito) {
                                    ?>
                                    <option value="<?php echo $delito->id ?>"><?php echo $delito->delito ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                            <input type="hidden" name="delito_id" id="delito_ids"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="estado_id">Estado *</label>

                            <select id="estado_id" name="estado_id" style="width:100%" class="form-control" required>
                                <option value="0">Seleccione...</option>
                                <?php
                                foreach ($estado as $estado) {
                                    ?>
                                    <option value="<?php echo $estado->cod_estado ?>"><?php echo $estado->estado ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="abogado_defensor">Abogado *</label>
                            <select id="abogado_defensor" name="abogado_defensor" style="width:100%" class="form-control" required>
                                <option value="0">Seleccione...</option>
                                <option value="1">Publico</option>
                                <option value="2">Privado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="causa">Causa </label>
                            <input id="causa" name="causa" class="form-control" type="text" >
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                            <label for="fecha_de_presentacion">Fecha de Presentación</label>
                            <div class="col-md-12  has-feedback">
                                <input type="text"  readonly="readonly" style="background-color: #FFFFFF" id="fecha_de_presentacion" name="fecha_de_presentacion" class="form-control has-feedback-left">
                                <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label ">Detalles de la falta
                                <span class="required">*</span>
                            </label>
                            <textarea id="detalle_falta" name="detalle_falta" class="resizable_textarea form-control"  style="overflow: hidden; word-wrap: break-word; resize: horizontal;"></textarea>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12"></div>
                    </div>
                    <div class="input-group" style="margin-left: 40%;">
                        <br/>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="agregar">
                                    Aceptar
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registro de Reseñas</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $attributes = array('id' => 'frmresena', 'enctype' => "multipart/form-data");
                echo form_open('registro/resena/guardar', $attributes);
                ?>
                <?php echo form_hidden('token', $token) ?>

                <div id="wizard" class="form_wizard wizard_horizontal">
                    <ul class="wizard_steps">
                        <li>
                            <a href="#datos_personales">
                                <span class="step_no">1</span>
                                <span class="step_descr">
                                    Datos Personales<br />
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#rasgos_fisicos">
                                <span class="step_no">2</span>
                                <span class="step_descr">
                                    Rasgos Fisicos<br />
                                </span>
                            </a>
                        </li>
                        <li>

                            <a href="#div_fotos">
                                <span class="step_no">3</span>
                                <span class="step_descr">
                                    Fotos<br />
                                </span>
                            </a>
                        </li>
                        <li>

                            <a href="#div_resena">
                                <span class="step_no">4</span>
                                <span class="step_descr">
                                    Delito<br />
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div id="datos_personales">

                        <h2 class="StepTitle">Datos Personales</h2>
                        <input type="hidden" name="id" value="<?php echo $id ?>" id="id">
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="ci">Cédula de Identidad </label>
                                <input id="ci" name="ci" maxlength="8" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="nombres">Nombres *</label>
                                <input id="nombres" name="nombres"  style="background-color:#FFFFFF" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="apellidos">Apellidos *</label>
                                <input id="apellidos"    style="background-color:#FFFFFF" name="apellidos" class="form-control" type="text" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="nacionalidad">Nacionalidad *</label>
                                <select id="nacionalidad" name="nacionalidad" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_nacionalidad as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->nacionalidad ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="funcionario">Funcionario </label>
                                <select id="funcionario" name="funcionario" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <option value="1">Policia Estadal</option>
                                    <option value="2">Policia Nacional</option>
                                    <option value="3">Militar</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="estado_funcionario">Estado </label>
                                <select id="estado_funcionario" name="estado_funcionario" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <option value="1">Activo</option>
                                    <option value="2">De baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="from-group">
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="fecha_de_nacimiento">Fecha de Nacimiento *</label>
                                <div class="col-md-12  has-feedback">
                                    <input type="text"  readonly="readonly" style="background-color: #FFFFFF;" id="fecha_de_nacimiento" name="fecha_de_nacimiento" class="form-control has-feedback-left">
                                    <span aria-hidden="true" class="fa fa-calendar-o form-control-feedback left"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="edad">Edad *</label>
                                <input id="edad" disabled="disabled" style="background-color:#FFFFFF" name="edad" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="sexo">Sexo </label>
                                <select id="sexo" name="sexo" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <option value="1">Maculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="telefono_m">Telefono Movil </label>
                                <input id="telefono_m" name="telefono_m" maxlength="11" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="telefono_f">Telefono Fijo </label>
                                <input id="telefono_f" name="telefono_f" maxlength="11" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="estado_civil">Estado Civil *</label>
                                <select id="estado_civil" name="estado_civil" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <option value="1">Soltero(a)</option>
                                    <option value="2">Casado(a)</option>
                                    <option value="3">Divorciado(a)</option>
                                    <option value="4">Viudo(a)</option>
                                    <option value="5">Concubino(a)</option>
                                </select>
                            </div>
                        </div>
                        <div class="from-group">
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="madre">Madre</label>
                                <input id="madre" name="madre" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="padre">Padre </label>
                                <input id="padre" name="padre" class="form-control" type="text" >
                            </div>

                        </div>
                        <div class="from-group">
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="ocupacion">Ocupación</label>
                                <input id="ocupacion" name="ocupacion" class="form-control" type="text" >
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 ">
                                <label for="apodo">Apodo </label>
                                <input id="apodo" name="apodo" class="form-control" type="text" >
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 ">
                                <label for="fallecido">Fallecido </label>
                                <select id="fallecido" name="fallecido" class="form-control" style="width:100% !important;">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 ">
                                <label for="evadido">Evadido </label>
                                <select id="evadido" name="evadido" class="form-control" style="width:100% !important;">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label ">Dirección <span class="required">*</span>
                                </label>
                                <textarea id="direccion" name="direccion" class="resizable_textarea form-control"  style="overflow: hidden; word-wrap: break-word; resize: horizontal;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="rasgos_fisicos">
                        <h2 class="StepTitle">Rasgos Fisicos</h2>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="cabeza_id">Cabeza *</label>
                                <select id="cabeza_id" name="cabeza_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_cabeza as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    $lista = '';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="piel_id">Piel *</label>
                                <select id="piel_id" name="piel_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_piel as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="color_piel_id">Color *</label>
                                <select id="color_piel_id" name="color_piel_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_color_piel as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="frente_id">Frente *</label>
                                <select id="frente_id" name="frente_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_frente as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="ojos_id">Ojos *</label>
                                <select id="ojos_id" name="ojos_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_ojos as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="color_ojos_id">Color *</label>
                                <select id="color_ojos_id" name="color_ojos_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_color_ojos as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="cabello_id">Cabello *</label>
                                <select id="cabello_id" name="cabello_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_cabellos as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="color_cabello_id">Color *</label>
                                <select id="color_cabello_id" name="color_cabello_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_color_cabellos as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="cejas_id">Cejas *</label>
                                <select id="cejas_id" name="cejas_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_cejas as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="nariz_id">Nariz *</label>
                                <select id="nariz_id" name="nariz_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_nariz as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="boca_id">Boca *</label>
                                <select id="boca_id" name="boca_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_boca as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="labios_id">Labios *</label>
                                <select id="labios_id" name="labios_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_labios as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="contextura_id">Contextura *</label>
                                <select id="contextura_id" name="contextura_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_contextura as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="menton_id">Menton *</label>
                                <select id="menton_id" name="menton_id" class="form-control" style="width:100% !important;">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_menton as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="orejas_id">Orejas *</label>
                                <select id="orejas_id" name="orejas_id" class="form-inline" style="width: 100%">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    foreach ($lista_orejas as $lista) {
                                        ?>
                                        <option value="<?php echo $lista->id ?>"><?php echo $lista->descripcion ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-1 col-sm-8 col-xs-3 ">
                                <label for="estatura">Estatura *</label>
                                <input id="estatura" name="estatura" class="form-control" type="text" >
                            </div>

                            <div class="col-md-1 col-sm-8 col-xs-3 ">
                                <label for="peso">Peso *</label>

                                <input id="peso" name="peso" class="form-control" type="text" >
                            </div>


                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-3 col-xs-3 ">

                            </div>

                        </div>



                        <div class="form-group">

                            <!--                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                                            <label for="peso">Peso *</label>
                                                            <p></p>
                                                            <input id="peso" name="peso" class="form-control" type="text" >
                                                        </div>-->
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="lunares">Lunares *</label>
                                <p></p>


                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-default">
                                        <input type="radio"  value="1" name="lunares"> Si
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" checked="checked" value="0" name="lunares"> No
                                    </label>

                                </div>
                                <p></p>
                                <input id="lunares" disabled="disabled" maxlength="20" name="lunares_desc" placeholder="Descripción" class="form-control" type="text" >

                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="amputaciones">Amputaciones *</label>

                                <p></p>
                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-default ">
                                        <input type="radio"  value="1" name="amputaciones"> Si
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" value="0" checked="checked" name="amputaciones"> No
                                    </label>
                                </div>
                                <p></p>
                                <input id="amputaciones" disabled="" maxlength="20" name="amputaciones_desc" placeholder="Descripción" class="form-control" type="text" >
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="quemaduras">Quemaduras *</label>
                                <p></p>

                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-default">
                                        <input type="radio"  value="1" name="quemaduras"> Si
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" value="0"  checked="checked" name="quemaduras"> No
                                    </label>
                                </div>
                                <p></p>
                                <input id="quemaduras" disabled=""  maxlength="20" name="quemaduras_desc" placeholder="Descripción" class="form-control" type="text" >
                            </div>


                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="tatuajes">Tatuajes *</label>
                                <p></p>

                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-default">
                                        <input type="radio"  value="1" name="tatuajes"> Si
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" value="0" checked="checked" name="tatuajes"> No
                                    </label>
                                </div>
                                <p></p>
                                <input id="tatuajes"  disabled=""  maxlength="20" name="tatuajes_desc" placeholder="Descripción" class="form-control" type="text" >
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-3 col-xs-3 ">

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="protesis">Protesis *</label>
                                <p></p>


                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-default ">
                                        <input type="radio"  value="1" name="protesis"> Si
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" value="0" checked="checked" name="protesis"> No
                                    </label>
                                </div>
                                <p></p>
                                <input id="protesis_id" disabled="" maxlength="20" name="protesis_desc" placeholder="Descripción" class="form-control" type="text" >
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="cicatrices">Cicatrices *</label>
                                <p></p>
                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-default">
                                        <input type="radio" value="1" name="cicatrices"> Si
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" value="0" checked="checked"  name="cicatrices"> No
                                    </label>
                                </div>
                                <p></p>
                                <input id="cicatrices_id" disabled="" maxlength="20" name="cicatrices_desc" placeholder="Descripción" class="form-control" type="text" >
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 ">
                                <label for="cicatrices">Otro </label>
                                <p></p>
                                <input id="otro" name="otro" maxlength="50" class="form-control" type="text" >
                            </div>
                        </div>


                    </div>


                    <div id="div_fotos">
                        <h2 class="StepTitle">Fotos</h2>
                        <div class="form-group row">
                            <div id="kv-avatar-errors-1" class="center-block" style="width:800px;display:none"></div>
                            <div class="kv-avatar col-md-4 col-sm-4 col-xs-4" >
                                <input id="foto1" name="foto[]" type="file" class="file-loading foto">
                            </div>
                            <div class="kv-avatar col-md-4 col-sm-4 col-xs-4" >
                                <input id="foto2" name="foto[]" type="file" class="file-loading foto">
                            </div>
                            <div class="kv-avatar col-md-4 col-sm-4 col-xs-4">
                                <input id="foto2" name="foto[]" type="file" class="file-loading foto">
                            </div>
                        </div>
                    </div>

                    <div id="div_resena">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button  class="btn btn-positive btn-labeled" id="i_new_line"><i class="fa fa-plus"></i>&nbsp;Agregar Delito o Falta</button>
                            <div class="table-responsive">
                                <table id="tabla_delito" style="width:100%" class="tabla_delito table dataTable table-striped table-bordered dt-responsive nowrap jambo_table bulk_action">
                                    <thead>
                                        <tr>
                                            <th class="column-title">Decisión Tribunal</th>
                                            <th class="column-title">Delito o Falta</th>
                                            <th class="column-title">Estado</th>
                                            <th class="column-title">Abogado</th>
                                            <th class="column-title">Causa</th>
                                            <th class="column-title">Fecha Presentación</th>
                                            <th class="column-title">Detalles de la falta</th>
                                            <th class="column-title">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                </div>
                <?php echo form_close(); ?>
                <br/>
                <div class="ln_solid"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id="tblticket" class="tabla table dataTable table-striped table-bordered dt-responsive nowrap jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th class="column-title">#</th>
                                    <th class="column-title">Cedula</th>
                                    <th class="column-title">Nombres</th>
                                    <th class="column-title">F. Nac</th>
                                    <th class="column-title">Edad</th>
                                    <th class="column-title">Consulta</th>
                                    <th class="column-title">Modificar</th>
                                    <th class="column-title">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($lista_resena as $lista) {
                                    $fecha_nac = '';
                                    $edad = '';
                                    if ($lista->fecha_de_nacimiento != '') {
                                        $fecha_nac = $this->libreria->formatDate($lista->fecha_de_nacimiento, 'd/m/Y');
                                        $edad = $this->libreria->edad($lista->fecha_de_nacimiento);
                                    }
                                    ?>
                                    <tr id="<?php echo $lista->id ?>">
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $lista->ci ?></td>
                                        <td><?php echo $lista->nombres . ' ' . $lista->apellidos ?></td>
                                        <td><?php echo $fecha_nac; ?></td>
                                        <td><?php echo $edad; ?></td>
                                        <td>
                                            <span id="<?php echo $lista->ci ?>" class="pdf_resena" style="cursor:pointer">
                                                <i  class="fa fa-file-pdf-o fa-2x"></i>
                                            </span>
                                        </td>
                                        <td>
                                            <img class="cursor modificar" src="<?php echo assets_url('img/datatable/modificar.png') ?>" alt="">
                                        </td>
                                        <td>
                                            <img class="cursor eliminar" src="<?php echo assets_url('img/datatable/eliminar.png') ?>" alt="">
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('script/resena.js'); ?>" type="text/javascript" charset="utf-8" ></script>
