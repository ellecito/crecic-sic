<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar Usuario</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../../">Usuarios</a> / Editar
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" id="form-editar">
                                <div class="form-group">
                                    <label for="rut">RUT</label>
                                    <input name="rut" id="rut" class="form-control" placeholder="11.111.111-1" value="<?php echo $usuario->rut; ?>">
                                    <input name="codigo" id="codigo" type="hidden" value="<?php echo $usuario->codigo; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nombres">Nombres</label>
                                    <input name="nombres" id="nombres" class="form-control validate[required]" placeholder="Nombre Nombre" value="<?php echo $usuario->nombres; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_paterno">Apellido Paterno</label>
                                    <input name="apellido_paterno" id="apellido_paterno" class="form-control validate[required]" placeholder="Apellido Paterno" value="<?php echo $usuario->apellido_paterno; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_materno">Apellido Materno</label>
                                    <input name="apellido_materno" id="apellido_materno" class="form-control validate[required]" placeholder="Apellido Materno" value="<?php echo $usuario->apellido_materno; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" class="form-control validate[required, custom[email]]" placeholder="contacto@usuario.cl" value="<?php echo $usuario->email; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="region">Región</label>
                                    <select name="region" id="region" class="form-control">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($regiones){ ?>
                                            <?php foreach($regiones as $region){ ?>
                                            <option value="<?php echo $region->codigo; ?>" <?php if($region->codigo == $usuario->comuna->region->codigo) echo "selected"; ?>><?php echo $region->nombre; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comuna">Comuna</label>
                                    <select name="comuna" id="comuna" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($comunas){ ?>
                                        <?php foreach($comunas as $comuna){ ?>
                                         <option value="<?php echo $comuna->codigo; ?>" <?php if($comuna->codigo == $usuario->comuna->codigo) echo "selected"; ?>><?php echo $comuna->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="perfil">Perfil</label>
                                    <select name="perfil" id="perfil" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($perfiles){ ?>
                                        <?php foreach($perfiles as $perfil){ ?>
                                         <option value="<?php echo $perfil->codigo; ?>" <?php if($perfil->codigo == $usuario->perfil->codigo) echo "selected"; ?>><?php echo $perfil->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sucursal">Sucursal</label>
                                    <select name="sucursal" id="sucursal" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($sucursales){ ?>
                                        <?php foreach($sucursales as $sucursal){ ?>
                                         <option value="<?php echo $sucursal->codigo; ?>" <?php if($sucursal->codigo == $usuario->sucursal->codigo) echo "selected"; ?>><?php echo $sucursal->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
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