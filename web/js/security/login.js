$(document).ready(function() {

    $(".vaciuser").keyup(function() {
        this.value = this.value.replace(/[^a-z0-9]/g, '');
        if ($(this).val() != "") {
            $(".error").fadeOut('slow');
            return false;
        }
    });

    $('.boton').click(function(e) {
        e.preventDefault();
        var user = $.trim($(".vaciuser").val());
        var pass = $.trim($(".vacipass").val());

        $(".error").remove();
        $(".error2").remove();
        if (validar(user, pass)) {
            //if(true){
            enviar();
        }

    });

    function validar(user, pass) {

        if (user == "") {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba nombre de usuarioe.</center></div>");
            return false;
        } else if (user.length < 1 || user.length > 20) {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese un nombre maximo 20 caracteres.</center></div>");
            return false;
        } else if (pass == "") {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba una contrase&ntilde;a Válida.</center></div>");
            return false;
        } else if (pass.length < 6 || pass.length > 20) {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese una contrase&ntilde;a entre 6 y 20 digitos.</center></div>");
            return false;
        }

        return true;
    }

    function enviar() {
        $("#formu").submit();
    }


});
