<?php
    require_once 'sesion.validar.vista.php';
    
    require_once '../util/funciones/definiciones.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	
        <?php
	    include 'estilos.vista.php';
	?>

    </head>
    <body class="skin-green layout-top-nav">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php
                include 'cabecera.vista.php';
            ?>

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">REGISTRO DE PLAN DE FERTLIZACIÓN</h1>
                </section>

                <section class="content">
		    <!-- INICIO del formulario modal -->
		    <small>
		    <form id="frmgrabar">
			<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
			      </div>
			      <div class="modal-body">
				  <input type="hidden" name="txttipooperacion" id="txttipooperacion" class="form-control">
				  <div class="row">
				    <div class="col-xs-3">
					<p>Código Analisis de suelo<input type="text" name="txtcodigo" id="txtcodigo" class="form-control input-sm text-center text-bold" placeholder="" readonly=""></p>
				    </div>
				  </div>
                                  <p>Agricultor <font color = "red">*</font>
				      <select class="form-control input-sm" name="cboagricultormodal" id="cboagricultormodal" required="" >

				      </select>
				  </p>
                                  <p>Nombre <font color = "red">*</font>
				  	<input type="text" name="txtnombre" id="txtnombre" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Semilla <font color = "red">*</font>
				  	<input type="text" name="txtsemilla" id="txtsemilla" class="form-control input-sm" placeholder="" required=""><p>
				  <p>Ubicación <font color = "red">*</font>
				  	<input type="text" name="txtubicacion" id="txtubicacion" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>descripción <font color = "red">*</font>
				  	<input type="text" name="txtdescripcion" id="txtdescripcion" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>área <font color = "red">*</font>
				  	<input type="text" name="txtarea" id="txtarea" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>
				      Tipo de suelo <font color = "red">*</font>
				      <select class="form-control input-sm" name="cbosuelomodal" id="cbosuelomodal" required="" >

				      </select>
				  </p>
                                  <p>Nitrógeno <font color = "red">*</font>
				  	<input type="text" name="txtnitrogeno" id="txtnitrogeno" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Fósforo <font color = "red">*</font>
				  	<input type="text" name="txtfosforo" id="txtfosforo" class="form-control input-sm" placeholder="" required=""><p>				 
                                  <p>Potasio <font color = "red">*</font>
				  	<input type="text" name="txtpotasio" id="txtpotasio" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Calcio <font color = "red">*</font>
				  	<input type="text" name="txtcalcio" id="txtcalcio" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Magnesio <font color = "red">*</font>
				  	<input type="text" name="txtmagnesio" id="txtmagnesio" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Azufre <font color = "red">*</font>
				  	<input type="text" name="txtazufre" id="txtazufre" class="form-control input-sm" placeholder="" required=""><p>  
                                  <p>Boro <font color = "red">*</font>
				  	<input type="text" name="txtboro" id="txtboro" class="form-control input-sm" placeholder="" required=""><p>  
                                  <p>Cloro <font color = "red">*</font>
				  	<input type="text" name="txtcloro" id="txtcloro" class="form-control input-sm" placeholder="" required=""><p>  
                                  <p>Cobre <font color = "red">*</font>
				  	<input type="text" name="txtcobre" id="txtcobre" class="form-control input-sm" placeholder="" required=""><p>
				  <p>Hierro <font color = "red">*</font>
				  	<input type="text" name="txthierro" id="txthierro" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Magnesio <font color = "red">*</font>
				  	<input type="text" name="txtMagnesio" id="txtMagnesio" class="form-control input-sm" placeholder="" required=""><p> 
				  <p>Zing <font color = "red">*</font>
				  	<input type="text" name="txtzing" id="txtzing" class="form-control input-sm" placeholder="" required=""><p>
                                  <p>Silicio <font color = "red">*</font>
				  	<input type="text" name="txtsilicio" id="txtsilicio" class="form-control input-sm" placeholder="" required=""><p>
                                  
				  <p>
				      <font color = "red">* Campos obligatorios</font>
				  </p>
			      </div>
			      <div class="modal-footer">
				  <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
			</small>
		    <!-- FIN del formulario modal -->

                    <div class="row">
                        <div class="col-xs-3">
                            <select id="cbodepartamento" class="form-control input-sm"></select>
                        </div>

                        <div class="col-xs-3">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Agregar nuevo análisis de suelo</button>
                        </div>
                    </div>
                    <p>
                        <div class="box box-success">
                            <div class="box-body">
                                <div id="listado">
                                    
                                </div>
                            </div>
                        </div>
                    </p>
                </section>
            </div>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	<!--JS-->
	<script src="js/cargar-combos.js" type="text/javascript"></script>
        <script src="js/analisis-suelo.js" type="text/javascript"></script>

    </body>
</html>