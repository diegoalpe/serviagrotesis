$(document).ready(function(){
    cargarComboAgricultor("#cboagricultormodal","seleccione");
    listar();
});

$("#cbodepartamentomodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    cargarComboProvincia("#cboprovinciamodal", "todos", codigoDepartamento);
});
$("#cboprovinciamodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    var codigoProvincia = $("#cboprovinciamodal").val();
    cargarComboDistrito("#cbodistritomodal", "todos", codigoDepartamento, codigoProvincia);
});

function listar(){
    var codigoDepartamento = $("#cbodepartamento").val();
    if (codigoDepartamento === null){
        codigoDepartamento = 0;
    }
    
    var codigoProvincia = $("#cboprovincia").val();
    if (codigoProvincia === null){
        codigoProvincia = 0;
    }
    
    var codigoDistrito = $("#cbodistrito").val();
    if (codigoDistrito === null){
        codigoDistrito = 0;
    }
    
    $.post
    (
        "../controlador/agricultor.listar.controlador.php",
        {
            codigoDepartamento: codigoDepartamento,
            codigoProvincia: codigoProvincia,
            codigoDistrito: codigoDistrito
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>AGRICULTOR</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>EMAIL</th>';
            html += '<th>CELULAR </th>';
            html += '<th>DEPARTAMENTO</th>';
            html += '<th>PROVINCIA</th>';
            html += '<th>DISTRITO</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.direccion+'</td>';
                html += '<td>'+item.usuario+'</td>';
                html += '<td>'+item.num_celular+'</td>';
                html += '<td>'+item.departamento+'</td>';
                html += '<td>'+item.provincia+'</td>';
                html += '<td>'+item.distrito+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo + ')"><i class="fa fa-close"></i></button>';
		html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';
            
            $("#listado").html(html);
            
            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "asc"]]
            });
            
            
            
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
        
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error"); 
    });
    
}

$("#frmgrabar").submit(function(evento){
    evento.preventDefault();
    
    swal({
		title: "Confirme",
		text: "¿Esta seguro de grabar los datos ingresados?",
		
		showCancelButton: true,
		confirmButtonColor: '#3d9205',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: true,
                imageUrl: "../imagenes/pregunta.png"
	},
	function(isConfirm){ 

            if (isConfirm){ //el usuario hizo clic en el boton SI     
                
                //procedo a grabar
                
                $.post(
                    "../controlador/agricultor.agregar.editar.controlador.php",
                    {
                        p_datosFormulario: $("#frmgrabar").serialize()
                    }
                  ).done(function(resultado){                    
		      var datosJSON = resultado;

                      if (datosJSON.estado===200){
			  swal("Exito", datosJSON.mensaje, "success");
                          $("#btncerrar").click(); //Cerrar la ventana 
                          listar(); //actualizar la lista
                      }else{
                          swal("Mensaje del sistema", resultado , "warning");
                      }

                  }).fail(function(error){
			var datosJSON = $.parseJSON( error.responseText );
			swal("Error", datosJSON.mensaje , "error");
                  }) ;
                
            }
	});    
});


$("#btnagregar").click(function(){
    $("#txttipooperacion").val("agregar");
    $("#txtcodigo").val("");
    $("#txtpaterno").val("");
    $("#txtmaterno").val("");
    $("#txtnombre").val("");
    $("#txtdireccion").val("");
    $("#txtemail").val("");
    $("#txtcelular").val("");
    $("#cbodepartamentomodal").val("");
    $("#cboprovinciamodal").val("");
    $("#cbodistritomodal").val("");
    
    $("#titulomodal").text("Agregar nuevo Analisis de Suelo");
    
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtpaterno").focus();
});

function leerDatos( codigoCliente ){
    
    $.post
        (
            "../controlador/cliente.leer.datos.controlador.php",
            {
                p_codigoCliente: codigoCliente
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                
                $.each(datosJSON.datos, function(i,item) {
                    $("#txtcodigo").val( item.codigo_cliente );
                    $("#txtpaterno").val( item.apellido_paterno );
                    $("#txtmaterno").val( item.apellido_materno );
                    $("#txtnombre").val( item.nombres );
                    $("#txtdni").val( item.nro_documento_identidad );
                    $("#txtdireccion").val( item.direccion );
                    $("#txtfijo").val( item.telefono_fijo );
                    $("#txtmovil1").val( item.telefono_movil1 );
                    $("#txtmovil2").val( item.telefono_movil2 );
                    $("#txtcorreo").val( item.email );
                    $("#txtweb").val( item.direccion_web );
                    $("#cbodepartamentomodal").val( item.codigo_departamento );
                    $("#cboprovinciamodal").val( item.codigo_provincia );
                    $("#cbodistritomodal").val( item.codigo_distrito );
                    $("#txtclave").val( item.clave );
                    
                    //Ejecuta el evento change para llenar las categorÌas que pertenecen a la linea seleccionada
                    $("#cbodepartamentomodal").change();
                    $("#cboprovinciamodal").change();
                    $("#cbodistritomodal").change();
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        $("#cbodepartamentoamodal").val( item.codigo_departamento );
                    });
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        $("#cboprovinciamodal").val( item.codigo_provincia );
                    });
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        $("#cbodistritomodal").val( item.codigo_distrito );
                    });
                    
                    $("#txttipooperacion").val("editar");
                    
                });
                
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        });
    
}