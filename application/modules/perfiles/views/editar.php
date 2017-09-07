<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar Perfil</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../../">Perfil</a> / Editar
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" id="form-editar">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input name="nombre" id="nombre" class="form-control validate[required]" placeholder="Nombre" value="<?php echo $perfil->nombre; ?>">
                                    <input name="codigo" id="codigo" type="hidden" value="<?php echo $perfil->codigo; ?>">
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