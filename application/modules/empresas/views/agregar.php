<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Agregar Empresa</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../">Empresas</a> / Agregar
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
                                    <label for="razon_social">Razón Social</label>
                                    <input name="razon_social" id="razon_social" class="form-control validate[required]" placeholder="Nombre Empresa">
                                </div>
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input name="direccion" id="direccion" class="form-control validate[required]" placeholder="Calle 123, Ciudad">
                                </div>
                                <div class="form-group">
                                    <label for="contacto">Contacto</label>
                                    <input name="contacto" id="contacto" class="form-control validate[required]">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" class="form-control validate[required, custom[email]]" placeholder="contacto@empresa.cl">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input name="telefono" id="telefono" class="form-control validate[required, custom[phone]]">
                                </div>
                                <div class="form-group">
                                    <label for="giro">Giro</label>
                                    <select name="giro" id="giro" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($giros){ ?>
                                        <?php foreach($giros as $giro){ ?>
                                         <option value="<?php echo $giro->codigo; ?>"><?php echo $giro->nombre; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="rubro">Rubro</label>
                                    <select name="rubro" id="rubro" class="form-control validate[required]">
                                        <option disabled selected>Seleccione</option>
                                        <?php if($rubros){ ?>
                                        <?php foreach($rubros as $rubro){ ?>
                                         <option value="<?php echo $rubro->codigo; ?>"><?php echo $rubro->nombre; ?></option>
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
                                <button type="submit" class="btn btn-default">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>