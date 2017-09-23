<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar Estudio de Factibilidad</h1>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#datos" data-toggle="tab">Datos</a></li>
        <li><a href="#cronograma" data-toggle="tab">Cronograma</a></li>
        <li><a href="#requerimientos" data-toggle="tab">Requerimientos</a></li>
        <li><a href="#presupuesto" data-toggle="tab">Presupuesto</a></li>
    </ul>
    <form id="form-editar">
    <div class="tab-content">
        <div class="tab-pane active" id="datos">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Datos Principales
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tipo_curso">Tipo Curso</label>
                                            <select name="tipo_curso" id="tipo_curso" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($tipo_cursos){ ?>
                                                <?php foreach($tipo_cursos as $tipo_curso){ ?>
                                                <option value="<?php echo $tipo_curso->codigo; ?>" <?php if($tipo_curso->codigo == $estudio_factibilidad->tipo_curso->codigo) echo "selected"; ?>><?php echo $tipo_curso->nombre; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label for="sucursal">Sucursal</label>
                                            <select name="sucursal" id="sucursal" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($sucursales){ ?>
                                                <?php foreach($sucursales as $sucursal){ ?>
                                                <option value="<?php echo $sucursal->codigo; ?>"><?php echo $sucursal->nombre; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label for="curso">Curso</label>
                                            <select name="curso" id="curso" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($cursos){ ?>
                                                <?php foreach($cursos as $curso){ ?>
                                                <option value="<?php echo $curso->codigo; ?>" data-subtext="<?php echo $curso->sence; ?>" <?php if($curso->codigo == $estudio_factibilidad->curso->codigo) echo "selected"; ?>><?php echo $curso->nombre; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label for="empresa">Cliente</label>
                                            <select name="empresa" id="empresa" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($empresas){ ?>
                                                <?php foreach($empresas as $empresa){ ?>
                                                <option value="<?php echo $empresa->codigo; ?>"><?php echo $empresa->razon_social; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label for="nombre">Nombre Diploma</label>
                                            <input class="form-control validate[required]" name="nombre" id="nombre" value="<?php echo $estudio_factibilidad->nombre_diploma; ?>">
                                            <label for="tipo_manual">Tipo Manual</label>
                                            <select name="tipo_manual" id="tipo_manual" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($tipo_manuales){ ?>
                                                <?php foreach($tipo_manuales as $tipo_manual){ ?>
                                                <option value="<?php echo $tipo_manual->codigo; ?>" <?php if($tipo_manual->codigo == $estudio_factibilidad->tipo_manual->codigo) echo "selected"; ?>><?php echo $tipo_manual->nombre; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default">Editar</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Correlativo</label>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input class="form-control" readonly name="codigo" id="codigo" value="<?php echo $estudio_factibilidad->codigo; ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" readonly value="<?php  echo date('Y', strtotime($estudio_factibilidad->fecha_emision));?>">
                                                </div>
                                            </div>
                                            <label>Fecha</label>
                                            <input class="form-control" readonly value="<?php  echo date('d/m/Y');?>">
                                            <label for="direccion">Dirección Realización</label>
                                            <input class="form-control validate[required]" name="direccion" id="direccion" value="<?php echo $estudio_factibilidad->direccion_realizacion; ?>">
                                            <label for="obs">Observación</label>
                                            <textarea class="form-control validate[required]" name="obs" id="obs"><?php echo $estudio_factibilidad->obs; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="cronograma">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Horarios
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="horas">Horas</label>
                                                    <input class="form-control validate[required, custom[integer]]" readonly name="horas" id="horas" value="<?php echo $estudio_factibilidad->curso->horas; ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="alumnos">Alumnos</label>
                                                    <input class="form-control validate[required, custom[integer]]" readonly name="alumnos" id="alumnos" value="<?php echo $estudio_factibilidad->curso->alumnos; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="fecha_inicio">Fecha Inicio</label>
                                                    <input class="form-control date validate[required, custom[date]]" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("d/m/Y", strtotime($estudio_factibilidad->fecha_inicio)); ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="fecha_termino">Fecha Término</label>
                                                    <input class="form-control date validate[required, custom[date]]" name="fecha_termino" id="fecha_termino" value="<?php echo date("d/m/Y", strtotime($estudio_factibilidad->fecha_termino)); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="generar_cronograma" class="btn btn-default">Generar</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="dias">Días</label>
                                                <br/>
                                                <label class="checkbox-inline"><input type="checkbox" value="1" name="dias[]">Lu</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="2" name="dias[]">Ma</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="3" name="dias[]">Mi</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="4" name="dias[]">Ju</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="5" name="dias[]">Vi</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="6" name="dias[]">Sa</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="7" name="dias[]">Do</label>
                                                <br/><br/>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label for="desde">Desde</label>
                                                    <input class="form-control time validate[required]" name="desde" id="desde">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="hasta">Hasta</label>
                                                    <input class="form-control time validate[required]" name="hasta" id="hasta">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="desde2">Desde</label>
                                                    <input class="form-control time" name="desde2" id="desde2">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="hasta2">Hasta</label>
                                                    <input class="form-control time" name="hasta2" id="hasta2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Días
                        </div>
                        <div class="panel-body" id="cronograma_generado">
                                <div class="row">
                                    <div class="col-lg-1">
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Día</b>
                                    </div>
                                    <div class="col-lg-2">
                                    <b>Fecha</b>
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Desde</b>
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Hasta</b>
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Desde</b>
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Hasta</b>
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Horas</b>
                                    </div>
                                    <div class="col-lg-2">
                                    <b>Observación</b>
                                    </div>
                                    <div class="col-lg-1">
                                    <b>Eliminar</b>
                                    </div>
                                </div>
                                <br>
                                <?php $total = 0; foreach($cronogramas as $cronograma){ 
                                $diff = strtotime(str_replace("/", "-", $cronograma->hora_fin_d)) - strtotime(str_replace("/", "-", $cronograma->hora_inicio_d));
                                $horas = $diff/3600;
                                if($cronograma->hora_inicio_t && $cronograma->hora_fin_t){
                                    $diff = strtotime(str_replace("/", "-", $cronograma->hora_fin_t)) - strtotime(str_replace("/", "-", $cronograma->hora_inicio_t));
                                    $horas+= $diff/3600;
                                }
                                ?>
                                <div class="row">
					                <div class="col-lg-1"><input name="i[]" class="form-control" readonly value="<?php  echo $cronograma->codigo; ?>"></div>
                                    <div class="col-lg-1"><?php echo ucfirst(strftime("%A", strtotime($cronograma->fecha))); ?></div>
                                    <div class="col-lg-2"><input name="fecha_c[]" class="form-control" readonly value="<?php echo date("d/m/Y", strtotime($cronograma->fecha)); ?>"></div>
                                    <div class="col-lg-1"><input name="desde_c[]" class="form-control time hora_c" value="<?php echo  $cronograma->hora_inicio_d; ?>"></div>
                                    <div class="col-lg-1"><input name="hasta_c[]" class="form-control time hora_c" value="<?php echo  $cronograma->hora_fin_d; ?>"></div>
                                    <div class="col-lg-1"><input name="desde2_c[]" class="form-control time hora_c" value="<?php echo  $cronograma->hora_inicio_t; ?>"></div>
                                    <div class="col-lg-1"><input name="hasta2_c[]" class="form-control time hora_c" value="<?php echo  $cronograma->hora_fin_t; ?>"></div>
                                    <div class="col-lg-1 total_c"><?php echo $horas; ?></div>
                                    <div class="col-lg-2"><textarea name="obs_c[]" id="obs_c[]" class="form-control"><?php echo  $cronograma->obs; ?></textarea></div>
                                    <div class="col-lg-1"><a title="Eliminar" type="button" class="btn btn-danger btn-sm eliminar" rel="<?php echo $horas; ?>"><i class="fa fa-trash"></i></a></div>
                                </div>
                                <?php $total+= $horas; } ?>
                                <div class="row">
                                <div class="col-lg-1"><a href="#" id="agregar_c">Agregar</a></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-1"><b>Total</b></div>
                                <div class="col-lg-2" style="color: <?php 
                                    if($total != $estudio_factibilidad->curso->horas) echo 'red';
                                    else echo 'green';
                                ?>" id="total_c"><?php echo $total; ?></div>
                                <div class="col-lg-1"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="requerimientos">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Requerimientos técnicos
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="obs_t">Observación</label>
                                            <textarea class="form-control validate[required]" name="obs_t" id="obs_t"><?php echo $requerimiento_tecnico->obs; ?></textarea>
                                            <label for="respuesta_t">Respuesta</label>
                                            <textarea class="form-control" readonly name="respuesta_t" id="respuesta_t"></textarea>
                                            <input type="hidden" name="codigo_rt" value="<?php echo $requerimiento_tecnico->codigo; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Requerimientos</label>
                                                <br/>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="computadores" <?php if($requerimiento_tecnico->computadores != "f") echo "checked"; ?>>Computadores</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="proyector" <?php if($requerimiento_tecnico->proyector != "f") echo "checked"; ?>>Proyector</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="pizarra" <?php if($requerimiento_tecnico->pizarra != "f") echo "checked"; ?>>Pizarra</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="arriendo" <?php if($requerimiento_tecnico->arriendo != "f") echo "checked"; ?>>Arriendo Sala</label>
                                                <br/><br/>
                                            <label for="sala">Sala</label>
                                            <input class="form-control validate[required, custom[integer]]" name="sala" id="sala" value="<?php echo $requerimiento_tecnico->sala; ?>">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Requerimientos académicos
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="obs_a">Observación</label>
                                            <textarea class="form-control validate[required]" name="obs_a" id="obs_a"><?php echo $requerimiento_academico->obs; ?></textarea>
                                            <label for="respuesta_a">Respuesta</label>
                                            <textarea class="form-control" readonly name="respuesta_a" id="respuesta_a"></textarea>
                                            <input type="hidden" name="codigo_ra" value="<?php echo $requerimiento_academico->codigo; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Relatores</label>
                                            <select name="usuario[]" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($usuarios){ ?>
                                                <?php foreach($usuarios as $usuario){ ?>
                                                <option value="<?php echo $usuario->codigo; ?>" <?php if($usuario->codigo == $relatores[0]) echo "selected"; ?> data-subtext="<?php echo $usuario->nombres; ?>"><?php echo $usuario->apellido_paterno . " " . $usuario->apellido_materno; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <select name="usuario[]" class="form-control">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($usuarios){ ?>
                                                <?php foreach($usuarios as $usuario){ ?>
                                                <option value="<?php echo $usuario->codigo; ?>" <?php if($relatores[1] && $usuario->codigo == $relatores[1]) echo "selected"; ?> data-subtext="<?php echo $usuario->nombres; ?>"><?php echo $usuario->apellido_paterno . " " . $usuario->apellido_materno; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Requerimientos adquisición
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="obs_a">Observación</label>
                                            <textarea class="form-control validate[required]" name="obs_d" id="obs_a"><?php echo $requerimiento_adquisicion->obs; ?></textarea>
                                            <label for="respuesta_a">Respuesta</label>
                                            <textarea class="form-control" readonly name="respuesta_d" id="respuesta_a"></textarea>
                                            <input type="hidden" name="codigo_rd" value="<?php echo $requerimiento_adquisicion->codigo; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="coctel">Coctel</label>
                                            <select name="coctel" id="coctel" class="form-control validate[required]">
                                                <option value="0" <?php if(!$coctel) echo "selected"; ?>>No</option>
                                                <option value="1" <?php if($coctel) echo "selected"; ?>>Si</option>
                                            </select>
                                            <input type="hidden" name="codigo_coctel" value="<?php echo $coctel->codigo; ?>">
                                            <label for="fecha_coctel">Fecha</label>
                                            <input class="form-control date validate[required]" id="fecha_coctel" name="fecha_coctel" value="<?php echo date("d/m/Y", strtotime($coctel->fecha)); ?>">
                                            <label for="hora_coctel">Hora</label>
                                            <input class="form-control time validate[required]" id="hora_coctel" name="hora_coctel" value="<?php echo date("H:i", strtotime($coctel->fecha)); ?>">
                                            <label for="direccion_coctel">Dirección/Lugar</label>
                                            <input class="form-control validate[required]" id="direccion_coctel" name="direccion_coctel" value="<?php echo $coctel->direccion; ?>">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>