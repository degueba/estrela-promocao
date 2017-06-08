// Set the date we're counting down to
var countDownDate = new Date("Jun 8, 2017 18:21:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    $("#dias").html(days);
    $("#horas").html(hours);
    $("#minutos").html(minutes);
    $("#segundos").html(seconds);


    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);


function camposIguais(campo1, campo2, msg) {
    if ($("#" + campo1).val() != "" && $("#" + campo2).val() != "") {
        if ($("#" + campo1).val() != $("#" + campo2).val()) {
            $("#" + campo1 + ", #" + campo2).val("").attr("placeholder", "Valores não coincidem").addClass("erro-igualdade").parent(".form-group").removeClass('acerto-igualdade');
        } else {
            $("#" + campo1 + ", #" + campo2).attr("placeholder", "").removeClass("erro-igualdade").parent(".form-group").addClass("acerto-igualdade");
        }
    }
}

function removeProdutoEstrela(n) {
    $(n).remove();
}

jQuery(function() {
    $("#telefone").mask("(99) 9999-9999?9");
    $("#cpf").mask("999.999.999-99");


    $(".mask_valor_produto").maskMoney({
        decimal: ",",
        thousands: "."
    });

    // PÁGINA CUPOM
    var NUMERACAO_CAMPO = 0;

    $(".btn-add-produto").on("click", function() {
        $container = $(".produto_estrela");

        var n = NUMERACAO_CAMPO++;

        $container_clone = $container.clone();
        $container_clone.appendTo($container.parent()).removeClass("produto_estrela").addClass("produto_estrela-" + n);

        $container_clone.children(".valor_produto").append('<button type="button" class="btn btn-danger" onclick="removeProdutoEstrela(\'.produto_estrela-' + n + '\');">x</button>');
        $container_clone.children(".valor_produto").children(".btn-danger").css({
            'position': 'absolute',
            'right': '15px',
            'top': '30px',
            'border-top-right-radius': '19px',
            'border-bottom-right-radius': '19px',
            'border-top-left-radius': '0px',
            'border-bottom-left-radius': '0px'
        });


        // Limpando os campos
        $container_clone.children(".nome_produto").children("input").val("");
        $container_clone.children(".valor_produto").children("input").val("");

        $('#form-cadastrar-nota').animate({
            scrollTop: $(this).offset().top
        }, 2000);

        $(".mask_valor_produto").maskMoney({
            decimal: ",",
            thousands: "."
        });

    });






    var $doc = $('html, body');

    // Scroll Suave
    $('.scroll-suave').click(function() {
        $doc.animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);

        $(".scroll-suave").parent("li.active").each(function() {
            $(this).removeClass("active");
        });

        $(this).parent("li").addClass("active");

        return false;
    });

    // Scroll nav header
    $(window).scroll(function() {
        var $this = $(this),
            $navHeader = $("#menu-nav");

        if ($this.scrollTop() > 120) {
            $("#menu-nav").addClass("navbar-nav-mobile");
        } else {
            $("#menu-nav").removeClass("navbar-nav-mobile");
        }

    });


    // Cadastro
    $("#form-cadastro").on("submit", function(event) {
        event.preventDefault();

        // Loading
        $("#cadastrar-usuario").html('<span class="loading">&nbsp;&nbsp;<img src="../images/loading.gif" class=""></span>');

        var dados = $("#form-cadastro").serialize();


        $.ajax({
            type: "POST",
            url: "cadastro",
            data: dados,
            datatype: 'json',
            success: function(data) {
                if (data.retorno.sucesso == false) {
                    // Loading
                    $("#cadastrar-usuario").html('Cadastrar');

                    swal(
                        'Oops...',
                        data.retorno.msg,
                        'error'
                    )
                } else {
                    location.href = data.retorno.redirecionar;
                }
            }, //END success
            error: function(e) {
                swal(
                    'Erro',
                    e,
                    'error'
                )
            }

        });

    });


    // Login
    $("#form-login").on("submit", function(event) {

        event.preventDefault();

        // Loading
        $("#entrar-usuario").html('<span class="loading">&nbsp;&nbsp;<img src="../images/loading.gif" class=""></span>');

        var dados = $("#form-login").serialize();

        $.ajax({
            type: "POST",
            url: "logar",
            data: dados,
            datatype: 'json',
            success: function(data) {
                $("#entrar-usuario").html('Entrar');

                if (data.retorno.sucesso == false) {
                    swal(
                        'Oops...',
                        data.retorno.msg,
                        'error'
                    )
                } else {
                    location.href = data.retorno.redirecionar;
                }
            }, //END success
            error: function(e) {
                swal(
                    'Erro',
                    e,
                    'error'
                )
            }

        });

    });



});