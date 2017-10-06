<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Agregar Estudio de Factibilidad</h1>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#datos" data-toggle="tab">Datos</a></li>
        <li><a href="#cronograma" data-toggle="tab">Cronograma</a></li>
        <li><a href="#requerimientos" data-toggle="tab">Requerimientos</a></li>
        <li><a href="#presupuesto" data-toggle="tab" style="display: none;">Presupuesto</a></li>
    </ul>
    <form id="form-agregar">
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
                                                <option value="<?php echo $tipo_curso->codigo; ?>"><?php echo $tipo_curso->nombre; ?></option>
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
                                                <option value="<?php echo $curso->codigo; ?>" data-subtext="<?php echo $curso->sence; ?>"><?php echo $curso->nombre; ?></option>
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
                                            <input class="form-control validate[required]" name="nombre" id="nombre">
                                            <label for="tipo_manual">Tipo Manual</label>
                                            <select name="tipo_manual" id="tipo_manual" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($tipo_manuales){ ?>
                                                <?php foreach($tipo_manuales as $tipo_manual){ ?>
                                                <option value="<?php echo $tipo_manual->codigo; ?>"><?php echo $tipo_manual->nombre; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default">Agregar</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Correlativo</label>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input class="form-control" readonly>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" readonly value="<?php  echo date('Y');?>">
                                                </div>
                                            </div>
                                            <label>Fecha</label>
                                            <input class="form-control" readonly value="<?php  echo date('d/m/Y');?>">
                                            <label for="direccion">Dirección Realización</label>
                                            <input class="form-control validate[required]" name="direccion" id="direccion">
                                            <label for="obs">Observación</label>
                                            <textarea class="form-control validate[required]" name="obs" id="obs"></textarea>
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
                                                    <input class="form-control validate[required, custom[integer]]" readonly name="horas" id="horas">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="alumnos">Alumnos</label>
                                                    <input class="form-control validate[required, custom[integer]]" readonly name="alumnos" id="alumnos">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="fecha_inicio">Fecha Inicio</label>
                                                    <input class="form-control date validate[required, custom[date]]" name="fecha_inicio" id="fecha_inicio">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="fecha_termino">Fecha Término</label>
                                                    <input class="form-control date validate[required, custom[date]]" name="fecha_termino" id="fecha_termino">
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
                                            <textarea class="form-control validate[required]" name="obs_t" id="obs_t"></textarea>
                                            <label for="respuesta_t">Respuesta</label>
                                            <textarea class="form-control" readonly name="respuesta_t" id="respuesta_t"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Requerimientos</label>
                                                <br/>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="computadores">Computadores</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="proyector">Proyector</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="pizarra">Pizarra</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="t" name="arriendo">Arriendo Sala</label>
                                                <br/><br/>
                                            <label for="sala">Sala</label>
                                            <input class="form-control validate[required, custom[integer]]" name="sala" id="sala">
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
                                            <textarea class="form-control validate[required]" name="obs_a" id="obs_a"></textarea>
                                            <label for="respuesta_a">Respuesta</label>
                                            <textarea class="form-control" readonly name="respuesta_a" id="respuesta_a"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Relatores</label>
                                            <select name="usuario[]" class="form-control validate[required]">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($usuarios){ ?>
                                                <?php foreach($usuarios as $usuario){ ?>
                                                <option value="<?php echo $usuario->codigo; ?>" data-subtext="<?php echo $usuario->nombres; ?>"><?php echo $usuario->apellido_paterno . " " . $usuario->apellido_materno; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <select name="usuario[]" class="form-control">
                                                <option disabled selected>Seleccione</option>
                                                <?php if($usuarios){ ?>
                                                <?php foreach($usuarios as $usuario){ ?>
                                                <option value="<?php echo $usuario->codigo; ?>" data-subtext="<?php echo $usuario->nombres; ?>"><?php echo $usuario->apellido_paterno . " " . $usuario->apellido_materno; ?></option>
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
                                            <textarea class="form-control validate[required]" name="obs_d" id="obs_a"></textarea>
                                            <label for="respuesta_a">Respuesta</label>
                                            <textarea class="form-control" readonly name="respuesta_d" id="respuesta_a"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="coctel">Coctel</label>
                                            <select name="coctel" id="coctel" class="form-control validate[required]">
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                            <label for="fecha_coctel">Fecha</label>
                                            <input class="form-control date validate[required]" id="fecha_coctel" name="fecha_coctel">
                                            <label for="hora_coctel">Hora</label>
                                            <input class="form-control time validate[required]" id="hora_coctel" name="hora_coctel">
                                            <label for="direccion_coctel">Dirección/Lugar</label>
                                            <input class="form-control validate[required]" id="direccion_coctel" name="direccion_coctel">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="presupuesto">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Costos Operativos
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">INGRESOS - VENTAS</div>
                                <div class="col-lg-3"><input type="text" readonly class="form-control validate[required]" name="ingreso_ventas" id="ingreso_ventas"></div>
                                <div class="col-lg-3">TOTAL INGRESO CAP (+)</div>
                                <div class="col-lg-3"><input type="text" readonly class="form-control validate[required]" name="total_ingreso" id="total_ingreso"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">COSTOS DIRECTOS (-)</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required]" name="costos_directos" id="costos_directos"></div>
                                <div class="col-lg-3">COSTOS FIJOS (-)</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required]" name="costos_fijos" id="costos_fijos"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">COMISION ASESOR</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required]" name="comision_asesor" id="comision_asesor"></div>
                                <div class="col-lg-3">UTILIDAD BRUTA</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required]" name="utilidad_bruta_p" id="utilidad_bruta_p"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">VH ALUMNO</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required]" name="valor_hh_a" id="valor_hh_a"></div>
                                <div class="col-lg-3">V ALUMNO</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required, integer]" name="valor_alumno" id="valor_alumno"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">VH RELATOR</div>
                                <div class="col-lg-3"><input readonly type="text" class="form-control validate[required]" name="valor_hh_r" id="valor_hh_r"></div>
                                <div class="col-lg-3"><b>BENEFICIO NETO</b></div>
                                <div class="col-lg-3"><input type="text" readonly class="form-control validate[required]" name="beneficio_neto" id="beneficio_neto"></div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-2">
                                    <b>COSTOS OPERACION</b>
                                </div>
                                <div class="col-lg-2">
                                    <b>UNITARIO</b>
                                </div>
                                <div class="col-lg-2">
                                    <b>ADICIONAL</b>
                                </div>
                                <div class="col-lg-2">
                                    <b>SUBTOTAL</b>
                                </div>
                                <div class="col-lg-2">
                                    <b>DETALLE</b>
                                </div>
                                <div class="col-lg-1">
                                    <b>CANTIDAD</b>
                                </div>
                                <div class="col-lg-1">
                                    <b>%</b>
                                </div>
                            </div>
                            <br>
                            <?php foreach($costos_fijos as $costo_fijo){ ?>
                            <div class="row">
                                <div class="col-lg-2">
                                    <input readonly class="form-control validate[required]" value="<?php echo $costo_fijo; ?>" name="nombre_costo[]">
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control validate[required, integer]" name="unitario[]">
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control validate[integer]" name="adicional[]">
                                </div>
                                <div class="col-lg-2">
                                    <input readonly class="form-control validate[required, integer]" name="subtotal[]">
                                </div>
                                <div class="col-lg-2">
                                    <textarea class="form-control validate[required]" name="detalle_costo[]"></textarea>
                                </div>
                                <div class="col-lg-1">
                                    <input class="form-control validate[required, integer]" name="cantidad_costo[]">
                                </div>
                                <div class="col-lg-1">
                                    <input class="form-control validate[required, integer, min[0], max[100]]" name="porcentaje[]">
                                </div>
                            </div>
                            <?php } ?>
                            <br>
                            <div class="row">
                                <div class="col-lg-2">
                                    <b>Total Costos Directos</b>
                                </div>
                                <div class="col-lg-2">
                                    <input readonly class="form-control validate[required]" name="total_u" id="total_u">
                                </div>
                                <div class="col-lg-2">
                                </div>
                                <div class="col-lg-2">
                                    <input readonly class="form-control validate[required]" name="total" id="total">
                                </div>
                                <div class="col-lg-2">
                                </div>
                                <div class="col-lg-1">
                                </div>
                                <div class="col-lg-1">
                                    <input readonly class="form-control validate[required]" name="total_p" id="total_p">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-3">
                                    <b>Asignación Costos Fijos (%)</b>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control validate[required]" name="porcentaje_cf" id="porcentaje_cf">
                                        <option disabled selected>Seleccione</option>
                                        <option value="18">18%</option>
                                        <option value="27">27%</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <b>Comisiones al Asesor (%)</b>
                                </div>
                                <div class="col-lg-3">
                                    <input class="form-control validate[required, integer, min[0], max[100]]" name="porcentaje_ca" id="porcentaje_ca">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-3">
                                    <b>Gasto Total</b>
                                </div>
                                <div class="col-lg-3">
                                    <input readonly class="form-control validate[required]" name="gasto_total" id="gasto_total">
                                </div>
                                <div class="col-lg-3">
                                    <b>Utilidad Bruta</b>
                                </div>
                                <div class="col-lg-3">
                                    <input readonly class="form-control validate[required]" name="utilidad_bruta" id="utilidad_bruta">
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