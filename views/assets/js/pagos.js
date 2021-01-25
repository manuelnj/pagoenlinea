$(document).ready(function() {
    ocultarDiv();
});

// cerrar div's
function ocultarDiv() {
    $(".divruc").hide();
    $(".divrsoc").hide();
    $(".divDomf").hide();
}

// calculo de importes y totales
$("#selCuota").change(function() {

    let nrocuota = $(this).val();

    // si no selecciono cuota o es "0"
    if (nrocuota == 0) {
        $("#valorImporte").val(0.00);
        $("#valorImpuesto").val(0.00);
        $("#valorTotalImporte").val(0.00);
        return;
    }


    let precio = $("#valorCuota").val();
    let tc = $("#valorTC").val();

    let importe = nrocuota * precio;
    importe = parseFloat(importe).toFixed(2);

    // centavo de dolar.
    let cDolar = parseFloat(0.15 * tc).toFixed(2);

    // total impuesto
    let totimp = (importe * 0.025) + parseFloat(cDolar);
    totimp = parseFloat(totimp).toFixed(2);

    // total final
    let t = parseFloat(totimp) + parseFloat(importe);

    $("#valorImporte").val(importe);
    $("#valorImpuesto").val(totimp);
    $("#valorTotalImporte").val(t);

});

// mostrar u ocultar campos.
$("#selDocumento").change(function() {

    let id = $(this).val();

    switch (id) {
        case "0":
            $(".divruc").hide();
            $(".divrsoc").hide();
            $(".divDomf").hide();
            break;
        case "BV":
            $(".divruc").hide();
            $(".divrsoc").hide();
            $(".divDomf").hide();
            break;
        case "FC":
            $(".divruc").show();
            $(".divrsoc").show();
            $(".divDomf").show();
            break;
        default:
            break;
    }



});

// obtener el precio de la casilla seleccionada.
$("#valorCasilla").change(function() {

    let casilla = $(this).val();
    let persona = $("#valorPersona").val();

    // console.log(casilla + ' ' + persona);

    if (casilla == 0) {
        swal({

            type: "error",

            title: "Seleccionar una casilla.",

            showConfirmButton: true,

            confirmButtonText: "Cerrar"

        })
    }

    $("#valorImporte").val(0);
    $("#valorImpuesto").val(0);
    $("#valorTotalImporte").val(0);

    $('#selCuota').prop('selectedIndex', 0);

    let datos = new FormData();

    datos.append("persona", persona);
    datos.append("casilla", casilla);

    $.ajax({
        url: "ajax/casilla.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            $("#valorCuota").val(respuesta["Monto"]);
        }

    })

});

$(".btnSiguiente").click(function() {

    let nroCuota = $("#selCuota").val();
    let tipoDoc = $("#selDocumento").val();

    // si el numero de cuotas es 0
    if (nroCuota == 0) {

        swal({

            type: "error",

            title: "Seleccionar el número de cuotas a pagar.",

            showConfirmButton: true,

            confirmButtonText: "Cerrar"

        })

        return false;
    }

    // si no selecciona ningún tipo de documento.
    if (tipoDoc == 0) {

        swal({

            type: "error",

            title: "Seleccionar un tipo de comprobante de pago.",

            showConfirmButton: true,

            confirmButtonText: "Cerrar"

        })

        return false;
    }



});