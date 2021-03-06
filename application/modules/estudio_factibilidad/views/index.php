<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Estudios de Factibilidad</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: right;"><a href="agregar/" class="btn btn-primary" role="button">Agregar</a></div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($estudios_factibilidad){ ?>
                            <?php foreach($estudios_factibilidad as $estudio_factibilidad){ ?>
                            <tr class="odd gradeX">
                                <td><?php echo $estudio_factibilidad->codigo; ?></td>
                                <td><?php echo $estudio_factibilidad->nombre_diploma; ?></td>
                                <td>
                                    <?php if($estudio_factibilidad->estado){ ?>
                                        <button type="button" class="btn btn-primary btn-xs" rel="<?php echo $estudio_factibilidad->codigo .'-0'; ?>" >Enviado</button>
                                    <?php } else{ ?>
                                        <button type="button" class="btn btn-warning btn-xs estado" rel="<?php echo $estudio_factibilidad->codigo .'-1'; ?>">Borrador</button>
                                        <a href="editar/<?php echo $estudio_factibilidad->codigo; ?>/">
                                        <button type="button" class="btn btn-success btn-xs">Editar</button>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-xs eliminar" rel="<?php echo $estudio_factibilidad->codigo; ?>">Eliminar</button>
                                    <?php } ?>
                                    <?php if(!$estudio_factibilidad->estado and $this->session->userdata("usuario")->perfil->codigo == 2 and !$estudio_factibilidad->visado) { ?>
                                    <button type="button" class="btn btn-primary btn-xs visar" rel="<?php echo $estudio_factibilidad->codigo .'-1'; ?>" >Visar</button>
                                    <?php } ?>
                                </td>
                                <td>
                                <a type="button" class="btn btn-primary btn-xs" href="libro-clase/" target="_blank">Libro Clases</a>
                                <a type="button" class="btn btn-primary btn-xs" href="pdf/<?php echo $estudio_factibilidad->codigo; ?>" target="_blank">PDF</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>