$(document).ready(function(){
    cargarComboDepartamento("#cbodepartamento","todos");
    cargarComboDepartamento("#cbodepartamentomodal","seleccione");
    listar();
});

$("#cbodepartamento").change(function(){
    var codigodepartamento = $("#cbodepartamento").val();
    cargarComboProvincia("#cboprovincia", "todos", codigodepartamento);
    listar();
});

$("#cboprovincia").change(function(){
    listar();
});

$("#cbodepartamentomodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    cargarComboProvincia("#cboprovinciamodal", "todos", codigoDepartamento);
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
    
    $.post
    (
        "../controlador/distrito.listar.controlador.php",
        {
            codigo_departamento: codigoDepartamento,
            codigo_provincia: codigoProvincia
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
            html += '<th>NOMBRE</th>';
            html += '<th>DEPARTAMENTO</th>';
            html += '<th>PROVINCIA</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.departamento+'</td>';
                html += '<td>'+item.provincia+'</td>';
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
                    "../controlador/distrito.agregar.editar.controlador.php",
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
    $("#txtnombre").val("");
    $("#cbodepartamentomodal").val("");
    $("#cboprovinciamodal").val(""); 
    
    $("#titulomodal").text("Agregar nuevo Distrito");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtnombre").focus();
});

function leerDatos(codigo_distrito){
    
    $.post
        (
            "../controlador/distrito.leer.datos.controlador.php",
            {
                p_codigo_distrito: codigo_distrito
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                
                $.each(datosJSON.datos, function(i,item) {
                    $("#txtcodigo").val( item.codigo_distrito );
                    $("#txtnombre").val( item.nombre );
                    $("#cbodepartamentomodal").val( item.codigo_departamento ); 
                    $("#cboprovinciamodal").val( item.codigo_provincia );
                    
                    $("#cbodepartamentomodal").change();
                    
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        
                        $("#cboprovinciamodal").change();
                    });
                    
                    $("#txttipooperacion").val("editar");
                });
                
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        })
    
}


function eliminar(codigo_distrito){
   swal({
            title: "Confirme",
            text: "¿Esta seguro de eliminar el registro seleccionado?",

            showCancelButton: true,
            confirmButtonColor: '#d93f1f',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/eliminar.png"
	},
	function(isConfirm){
            if (isConfirm){
                $.post(
                    "../controlador/distrito.eliminar.controlador.php",
                    {
                        p_codigo_distrito: codigo_distrito
                    }
                    ).done(function(resultado){
                        var datosJSON = resultado;   
                        if (datosJSON.estado===200){ //ok
                            listar();
                            swal("Exito", datosJSON.mensaje , "success");
                        }

                    }).fail(function(error){
                        var datosJSON = $.parseJSON( error.responseText );
                        swal("Error", datosJSON.mensaje , "error");
                    });
                
            }
	});
   
}