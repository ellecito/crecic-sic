<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar Empresa</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../../">Empresas</a> / Editar
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" id="form-editar">
                                <div class="form-group">
                                    <label for="rut">RUT</label>
                                    <input name="rut" id="rut" class="form-control" placeholder="11.111.111-1" value="<?php echo $empresa->rut; ?>">
                                    <input name="codigo" id="codigo" type="hidden" value="<?php echo $empresa->codigo; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="razon_social">Razón Social</label>
                                    <input name="razon_social" id="razon_social" class="form-control validate[required]" placeholder="Nombre Empresa" value="<?php echo $empresa->razon_social; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input name="direccion" id="direccion" class="form-control validate[required]" placeholder="Calle 123, Ciudad" value="<?php echo $empresa->direccion; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" class="form-control validate[required, custom[email]]" placeholder="contacto@empresa.cl" value="<?php echo $empresa->email; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="giro">Giro</label>
                                    <select name="giro" id="giro" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($giros){ ?>
                                        <?php foreach($giros as $giro){ ?>
                                         <option value="<?php echo $giro->codigo; ?>" <?php if($giro->codigo == $empresa->giro->codigo) echo "selected"; ?>><?php echo $giro->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="region">Región</label>
                                    <select name="region" id="region" class="form-control">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($regiones){ ?>
                                        <?php foreach($regiones as $region){ ?>
                                        <option value="<?php echo $region->codigo; ?>" <?php if($region->codigo == $empresa->comuna->region->codigo) echo "selected"; ?>><?php echo $region->nombre; ?></option>
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
                                         <option value="<?php echo $comuna->codigo; ?>" <?php if($comuna->codigo == $empresa->comuna->codigo) echo "selected"; ?>><?php echo $comuna->nombre; ?></option>
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