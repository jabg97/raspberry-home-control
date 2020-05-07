$(document).ready(function() {


    $('.boton').click(function(e) {
        e.preventDefault();
        var email = $.trim($('#email').val());

        $(".error").remove();
        if (validar(email)) {
            //if(true){
            enviar();
        }

    });

    function validar(email) {

        if (!(/^([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3})$/.test(email))) {
            $(".error_div").focus().after(" <div class='error alert bg-danger text-white z-depth-4 hoverable imen'> <span  class='close' data-dismiss='alert' aria-label='close'>&times;</span><center><strong> <i class='fa fa-exclamation-circle left fa-1x'></i>&nbsp;&nbsp;Error!</strong> Escriba un email válido.</center></div>");
            return false;
        }

        return true;
    }

    function enviar() {
        $("#formu").submit();
    }


});