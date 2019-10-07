function cargarComboTipoNutriente(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/tipo_nutriente.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un tipo de nutriente</option>';
            }else{
                html += '<option value="0">Todos los tipos de nutrientes</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_tipo_nutriente+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboTipoNutriente(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/tipo_nutriente.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un tipo de nutriente</option>';
            }else{
                html += '<option value="0">Todos los tipos de nutrientes</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_tipo_nutriente+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboTipoSuelo(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/tipo_suelo.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un tipo de suelo</option>';
            }else{
                html += '<option value="0">Todos los tipos de suelo</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_tipo_suelo+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboCultivo2(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/cultivo2.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un cultivo</option>';
            }else{
                html += '<option value="0">Todos los cultivos</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_agricultor+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}



function cargarComboAgricultor(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/agricultor.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un agricultor</option>';
            }else{
                html += '<option value="0">Todos los agricultores</option>';
            }
            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_agricultor+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboDepartamento(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/departamento.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un Departamento</option>';
            }else{
                html += '<option value="0">Todos los Departamentos</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_departamento+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarCombo(p_nombreCombo, p_tipo, p_codigoLinea){
    $.post
    (
	"../controlador/departamento.cargar.combo.controlador.php",
        {
            p_codigoLinea: p_codigoLinea
        }
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una categoría</option>';
            }else{
                html += '<option value="0">Todas las categorías</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_categoria+'">'+item.descripcion+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}


function cargarComboProvincia(p_nombreCombo, p_tipo, p_codigoDepartamento){
    $.post
    (
	"../controlador/provincia.cargar.combo.controlador.php",
        {
            p_codigoDepartamento: p_codigoDepartamento
        }
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una provincia</option>';
            }else{
                html += '<option value="0">Todas las provincias</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_provincia+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}



        
        function cargarComboDistrito(p_nombreCombo, p_tipo, p_codigo_departamento ,p_codigo_provincia){
    $.post
    (
	"../controlador/distrito.cargar.combo.controlador.php",
        {
            codigoDepartamento: p_codigo_departamento,
            codigoProvincia: p_codigo_provincia
        }
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un distrito</option>';
            }else{
                html += '<option value="0">Todas los distritos</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_distrito+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}
function cargarComboPersonal(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/personal.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un dni</option>';
            }else{
                html += '<option value="0">Todas las lineas</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.dni+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}
        
        