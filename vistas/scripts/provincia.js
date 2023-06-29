var tabla;

//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e){
        guardaryeditar(e);
    })
}

//Funcion limpiar nos sirve para limpiar formularios
function limpiar(){
    
    $("#idprovincia").val("");
    $("#nombre").val("");
    $("#distritos").val("");

}

//Funcion mostar formulario para controlar como se muestra el formulario
function mostrarform(flag){
    limpiar();
    if (flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
    }
}

//Funcion cancelarForm para ayudar a ocultar el formulario
function cancelarform(){
    limpiar();
    mostrarform(false);
}

//Función listar
function listar(){
    tabla=$('#tbllistado').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatable
        "aServerSide": true,//Paginación y filtrado lo realiza el servidor
        dom: 'Bfrtip',//Definimos el elemento del control de la tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax":{
            url: "../ajax/provincia.php?op=listar",
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            },
        },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenamos (columna/orden)
    }).DataTable();
}


function guardaryeditar(e) {
    e.preventDefault(); //No se activa la acción predterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url:   "../ajax/provincia.php?op=guardaryeditar",
        type:  "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }

    });
    limpiar();
}

//Muestra los datos en el formulario
function mostrar(idprovincia){
    $.post("../ajax/provincia.php?op=mostrar", {idprovincia : idprovincia}, function(data, status){
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
		$("#num_distritos").val(data.distritos);
 		$("#idprovincia").val(data.idprovincia);
    })

}

//Función para desactivar registros
function desactivar(idprovincia){
    bootbox.confirm("¿Está Seguro de desactivar la Provincia?", function(result){
        if (result) {

            $.post("../ajax/provincia.php?op=desactivar", {idprovincia : idprovincia}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
    })
}

//Función para activar registros
function activar(idprovincia){
    bootbox.confirm("¿Está Seguro de activar la Provincia?", function(result){
        if (result) {

            $.post("../ajax/provincia.php?op=activar", {idprovincia : idprovincia}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
    })
}


init();