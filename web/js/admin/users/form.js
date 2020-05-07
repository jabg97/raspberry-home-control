$(document).ready(function() {

    $('#codigo').keyup(function() {
        this.value = this.value.replace(/[^a-z0-9]/g, '');
        if ($(this).val() != "") {
            $(".error").fadeOut('slow');
            return false;
        }
    });

    $('#password').keyup(function() {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
        if ($(this).val() != "") {
            $(".error2").fadeOut('slow');
            return false;
        }
    });





    $('#btn-validar').click(function(e) {
        e.preventDefault();
        var cod = $.trim($('#codigo').val());
        var pass = $.trim($('#password').val());
        var email = $.trim($('#email').val());
        var rol = $.trim($('#rol').val());


        $(".error").remove();
        $(".error2").remove();
        $(".error3").remove();
        $(".error4").remove();

        if ((cod != "" && pass == "")) {
            if (cod.length >= 6 && cod.length <= 20) {
                pass = cod;
            } else {
                if (cod.length < 6) {
                    pass = cod;
                    var i = 0;
                    do {
                        pass += ++i;
                    }
                    while (pass.length < 6);

                }

            }

            $(".error2_div").focus().after(" <div class='error2 alert bg-primary text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-info-circle left fa-1x'></i>&nbsp;&nbsp;</strong> La contraseña sera \"" + pass + "\".</center></div>");
            $('#password').val($.trim(pass));
            $('#password').focus();
        }

        if (validar(cod, pass, email, rol)) {
            //if(true){
            enviar();
        }

    });

    function validar(cod, pass, email, rol) {

        if (cod == "") {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Escriba nombre de usuarioe.</center></div>");
            return false;
        } else if (cod.length < 1 || cod.length > 20) {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left'></i>&nbsp;&nbsp;Error!</strong> Ingrese un nombre maximo 20 caracteres.</center></div>");
            return false;
        } else if ((pass != "" && pass.length < 6) || pass.length > 20) {
            $(".error2_div").focus().after(" <div class='error2 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Ingrese una contrase&ntilde;a entre 6 y 20 digitos.</center></div>");
            return false;
        } else if (!(/^([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3})$/.test(email))) {
            $(".error3_div").focus().after(" <div class='error3 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Escriba un email válido.</center></div>");
            return false;
        } else if (rol == "") {
            $(".error4_div").focus().after(" <div class='error4 alert bg-danger text-white z-depth-4 hoverable imen'><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Seleccione el rol.</center></div>");
            return false;
        }

        return true;
    }

    function enviar() {
        $("#insertForm").submit();
    }

});