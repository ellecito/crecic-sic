<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Agregar Usuario</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../">Usuarios</a> / Agregar
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" id="form-agregar">
                                <div class="form-group">
                                    <label for="rut">RUT</label>
                                    <input name="rut" id="rut" class="form-control" placeholder="11.111.111-1">
                                </div>
                                <div class="form-group">
                                    <label for="nombres">Nombres</label>
                                    <input name="nombres" id="nombres" class="form-control validate[required]" placeholder="Nombre Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_paterno">Apellido Paterno</label>
                                    <input name="apellido_paterno" id="apellido_paterno" class="form-control validate[required]" placeholder="Apellido Paterno">
                                </div>
                                <div class="form-group">
                                    <label for="apellido_materno">Apellido Materno</label>
                                    <input name="apellido_materno" id="apellido_materno" class="form-control validate[required]" placeholder="Apellido Materno">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" class="form-control validate[required, custom[email]]" placeholder="contacto@usuario.cl">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" id="password" type="password" class="form-control validate[required]" placeholder="******">
                                </div>
                                <div class="form-group">
                                    <label for="region">Región</label>
                                    <select name="region" id="region" class="form-control">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($regiones){ ?>
                                        <?php foreach($regiones as $region){ ?>
                                         <option value="<?php echo $region->codigo; ?>"><?php echo $region->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comuna">Comuna</label>
                                    <select name="comuna" id="comuna" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="perfil">Perfil</label>
                                    <select name="perfil" id="perfil" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($perfiles){ ?>
                                        <?php foreach($perfiles as $perfil){ ?>
                                         <option value="<?php echo $perfil->codigo; ?>"><?php echo $perfil->nombre; ?></option>
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
                                         <option value="<?php echo $sucursal->codigo; ?>"><?php echo $sucursal->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>