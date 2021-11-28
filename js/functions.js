$('form.ajax').on('submit', function (e) {
    e.preventDefault();
    var that = $(this),
    url = that.attr('action'),
    type = that.attr('method');
    var tutulo = $('.input1').val();
    var descripcion = $('.input2').val();
if (!titulo) {
        $(".error_msg").css("display", "block").text('Error: Debe agregar el titulo');
        $('.submitbtn').val('Agregar').attr("disabled", false);
    } else {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            cache: false,
            data: {
                'action': 'ajaxp',
                titulo: titulo,
                descripcion: descripcion,
            },
            beforeSend: function () {
                $('.submitbtn').val('Agregando...').attr("disabled", true);
            },
            success: function (response) {
                console.log(response)
                //Mostrar notificacion con UIkit
                UIkit.notification({
                    message: '<div class=uk-text-center uk-text-bold><span uk-icon=\icon: check\></span>Post Agregado</div>',
                    status: 'success',
                    timeout: 2000,
                });
                $('.submitbtn').val('Agregar').attr("disabled", false);
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    },
                });
        $('.ajax')[0].reset(); // reseteamos formulario
    }
});