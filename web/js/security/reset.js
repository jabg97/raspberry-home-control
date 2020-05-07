$(document).ready(function() {

    $(".vacipassN").keyup(function() {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '')
        if ($(this).val() != "") {
            $(".error2").fadeOut('slow');
            return false;
        }
    });

    $(".vacipassR").keyup(function() {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '')

        if ($(this).val() != "") {
            $(".error3").fadeOut('slow');
            return false;
        }
    });

    $('.boton').click(function(e) {
        e.preventDefault();
        var passN = $.trim($(".vacipassN").val());
        var passR = $.trim($(".vacipassR").val());

        if (validar(passN, passR)) {
            //if(true){
            $("#formu").submit();
        }

    });

    function validar(passN, passR) {
        $(".error2").remove();
        $(".error3").remove();
        if (passN == "") {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese la contrase&ntilde;a nueva.</center></div>");
            return false;
        } else if (passN.length < 6 || passN.length > 20) {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese una contrase&ntilde;a entre 6 y 20 caracteres.</center></div>");
            return false;
        } else if (passR == "") {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Repita la contrase&ntilde;a.</center></div>");
            return false;
        } else if (passR.length < 6 || passR.length > 20) {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese una contrase&ntilde;a entre 6 y 20 caracteres.</center></div>");
            return false;
        } else if (passN != passR) {
            $(".error3_div").focus().after(" <div class='error3 alert bg-warning text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-triangle left'></i>&nbsp;&nbsp;Error!</strong>La contrase&ntilde;a no coincide.</center></div>");
            $("#mensaje_different").modal('show');
            return false;
        }

        return true;
    }

});