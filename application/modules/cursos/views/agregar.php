<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Agregar Curso</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="../">Curso</a> / Agregar
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" id="form-agregar">
                                <div class="form-group">
                                    <label for="sence">Código Sence</label>
                                    <input name="sence" id="sence" class="form-control validate[required, custom[integer]]" placeholder="1234567890">
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input name="nombre" id="nombre" class="form-control validate[required]" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="horas">Horas</label>
                                    <input name="horas" id="horas" class="form-control validate[required, custom[integer]]" placeholder="200">
                                </div>
                                <div class="form-group">
                                    <label for="alumnos">Alumnos</label>
                                    <input name="alumnos" id="alumnos" class="form-control validate[required, custom[integer]]" placeholder="20">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_emision">Fecha Emisión</label>
                                    <input name="fecha_emision" id="fecha_emision" class="form-control validate[required, custom[date]] date" placeholder="dd/mm/yyyy">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_vencimiento">Fecha Vencimiento</label>
                                    <input name="fecha_vencimiento" id="fecha_vencimiento" class="form-control validate[required, custom[date]] date" placeholder="dd/mm/yyyy">
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