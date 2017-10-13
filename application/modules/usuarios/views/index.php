<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Usuarios</h1>
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
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($usuarios){ ?>
                            <?php foreach($usuarios as $usuario){ ?>
                            <tr class="odd gradeX">
                                <td><?php echo $usuario->codigo; ?></td>
                                <td><?php echo $usuario->rut; ?></td>
                                <td><?php echo $usuario->nombres . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno; ?></td>
                                <td>
                                <?php if($usuario->estado === "t"){ ?>
                                    <button type="button" class="btn btn-primary btn-xs estado" rel="<?php echo $usuario->codigo .'-0'; ?>" >Activo</button>
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-warning btn-xs estado" rel="<?php echo $usuario->codigo .'-1'; ?>">Inactivo</button>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                <a href="editar/<?php echo $usuario->codigo; ?>/">
                                    <button title="Editar" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>
                                </a>
                                <a href="editar/<?php echo $usuario->codigo; ?>/">
                                    <button title="Editar" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </a>
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