<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar Curso</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../../">Curso</a> / Editar
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" id="form-editar">
                                <div class="form-group">
                                    <label for="sence">Código Sence</label>
                                    <input name="sence" id="sence" class="form-control validate[required, custom[integer]]" placeholder="1234567890" value="<?php echo $curso->sence; ?>">
                                    <input name="codigo" id="codigo" type="hidden" value="<?php echo $curso->codigo; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input name="nombre" id="nombre" class="form-control validate[required]" placeholder="Nombre" value="<?php echo $curso->nombre; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="horas">Horas</label>
                                    <input name="horas" id="horas" class="form-control validate[required, custom[integer]]" placeholder="200" value="<?php echo $curso->horas; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="alumnos">Alumnos</label>
                                    <input name="alumnos" id="alumnos" class="form-control validate[required, custom[integer]]" placeholder="20" value="<?php echo $curso->alumnos; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_emision">Fecha Emisión</label>
                                    <input name="fecha_emision" id="fecha_emision" class="form-control validate[required, custom[date]] date" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($curso->fecha_emision)); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_vencimiento">Fecha Vencimiento</label>
                                    <input name="fecha_vencimiento" id="fecha_vencimiento" class="form-control validate[required, custom[date]] date" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($curso->fecha_vencimiento)); ?>">
                                </div>
                                <button type="submit" class="btn btn-default">Editar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>