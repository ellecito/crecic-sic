<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tipo Curso</h1>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($tipo_cursos){ ?>
                            <?php foreach($tipo_cursos as $tipo_curso){ ?>
                            <tr class="odd gradeX">
                                <td><?php echo $tipo_curso->codigo; ?></td>
                                <td><?php echo $tipo_curso->nombre; ?></td>
                                <td style="text-align: center;">
                                <a href="editar/<?php echo $tipo_curso->codigo; ?>/">
                                    <button title="Editar" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>
                                </a>
                                <a href="editar/<?php echo $tipo_curso->codigo; ?>/">
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