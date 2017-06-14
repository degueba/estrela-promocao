// Set the date we're counting down to
var countDownDate = new Date("Aug 16, 2017 19:15:00").getTime();

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
        //        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);


function validandoData(dia, mes, ano) {
    var dataInicio = new Date("2017-06-15 00:00:00").getTime();
    var dataInput = new Date(ano + "-" + mes + "-" + dia + " 00:00:00").getTime();

    if (dataInput < dataInicio) {
        alert("Data inválida \n O sorteio começará no dia 15/06.");


        return false;
    }

    return true;
}


function camposIguais(campo1, campo2, msg) {
    if ($("#" + campo1).val() != "" && $("#" + campo2).val() != "") {
        if ($("#" + campo1).val() != $("#" + campo2).val()) {
            $("#" + campo1 + ", #" + campo2).val("").attr("placeholder", "Valores não coincidem").addClass("erro-igualdade").parent(".form-group").removeClass('acerto-igualdade');
        } else {
            $("#" + campo1 + ", #" + campo2).attr("placeholder", "").removeClass("erro-igualdade").parent(".form-group").addClass("acerto-igualdade");
        }
    }
}

var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);



function removeProdutoEstrela(n) {
    $(n).remove();
}

// FILTROS LOJAS \\
var PAGE = 1;
var PAGE_ITENS = 6;

function getLojas(pg, qt, estado, cidade) {

    params = { page: pg, qtd: qt };

    if (estado != "") {
        params = { page: pg, qtd: qt, uf: estado };
    }

    if (cidade != "") {
        params = { page: pg, qtd: qt, uf: estado, cidade: cidade };
    }


    $.ajax({
        type: "POST",
        url: "/getLojas",
        data: params,
        datatype: 'json',
        success: function(data) {
            console.log(data);
            var container = $(".lojas-fisica");
            var html = '<li class="box"><div class="content"></div></li>'

            if (data.lojas) {
                $(".btn-mais--lojas").show();

                for (var i = 0; i < data.lojas.length; i++) {
                    var box = $(html).appendTo(container);
                    box.html("<h2>" + data.lojas[i].nome + "</h2>")[i];
                    box.append("<address class='end'>" + data.lojas[i].cidade + ", " + data.lojas[i].uf + "</address>")[i];
                }



                if (data.lojas.length < 6) {
                    $(".btn-mais--lojas").hide();
                }
            } else {
                $(".btn-mais--lojas").hide();
            }



            PAGE++;

        }, //END success
        error: function(e) {
            swal(
                'Erro',
                e,
                'error'
            )
        }

    });
}



jQuery(function() {
    $("#telefone").mask("(99) 9999-9999?9");
    $("#cpf").mask("999.999.999-99");



    // PAGINA CUPOM
    if ($("body").hasClass("user-profile")) {


        // MÁSCARAS \\
        $("#dia, #mes").mask("99");
        $("#ano").mask("9999");
        $(".mask_valor_produto").maskMoney({
            decimal: ",",
            thousands: "."
        });
        $("#cnpj").mask("99.999.999/9999-99");
        // ** \\

        $("#form-cadastrar-nota").submit(function() {
            var dia = $("#dia").val();
            var mes = $("#mes").val();
            var ano = $("#ano").val();


            return validandoData(dia, mes, ano);


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

    }



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

    if (!isMobile) {
        $(window).scroll(function() {

            var $this = $(this),
                $navHeader = $("#menu-nav");

            if ($this.scrollTop() > 120) {
                $("#menu-nav").addClass("navbar-nav-mobile");
            } else {
                $("#menu-nav").removeClass("navbar-nav-mobile");
            }

        });
    } else {
        $(window).scroll(function() {

            // Menu mobile
            if ($('nav.nav-lateral-mobile').hasClass('mostrar')) {
                $('nav.nav-lateral-mobile').removeClass('mostrar');
            }

        });


    }





    // CADASTRO USUÁRIO \\
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
    // ||||||||||||||| \\


    // CHECKBOX REGULAMENTO \\
    $("#caixa-regulamento").click(function() {
        $('html, body').animate({
            scrollTop: $("#regulamento").offset().top
        }, 2000);
    });


    // LOGIN \\
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

    // ||||||||||||||| \\


    // ESQUECI MINHA SENHA \\


    $("#form-esqueci-minha-senha").on("submit", function(event) {

        event.preventDefault();

        // Loading
        $("#btn-recuperar").html('Enviando email...');

        var dados = $("#form-esqueci-minha-senha").serialize();

        $.ajax({
            type: "POST",
            url: "esqueciSenha",
            data: dados,
            datatype: 'json',
            success: function(data) {
                $("#btn-recuperar").html('Recuperar');

                if (data.retorno.sucesso == false) {
                    swal(
                        'Oops...',
                        data.retorno.msg,
                        'error'
                    )
                } else {
                    swal(
                        'Sucesso!',
                        data.retorno.msg,
                        'success'
                    )
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




    // |||||||||||||| \\


    $("#slt_estados").change(function() {
        var estado = $(this).val();
        var estadoOption = $("#slt_estados option:selected").val();

        if (estadoOption == "") {
            $("#slt_cidades").html("<option value=''>Cidade</option>");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/getCidades",
            data: { uf: estado },
            datatype: 'json',
            success: function(data) {

                var options = '';



                for (var i = 0; i < data.cidades.length; i++) {
                    options += '<option value="' + data.cidades[i].cidade + '">' + data.cidades[i].cidade + '</option>';
                }

                $("#slt_cidades").html(options);

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



    // FILTRAR
    $(".btn-filtrar").click(function(event) {
        event.preventDefault;
        $(".lojas-fisica").html('');
        PAGE = 1;
        $(".btn-mais--lojas").removeClass('hidden');

        var estado = $("#slt_estados option:selected").val();
        var cidade = $("#slt_cidades option:selected").val();

        if (estado != "") {
            if (cidade != "") {
                getLojas(PAGE, PAGE_ITENS, estado, cidade);
            } else {
                getLojas(PAGE, PAGE_ITENS, estado);
            }
        }


    });

    // MAIS LOJAS
    $(".btn-mais--lojas").click(function(event) {

        event.preventDefault;

        var estado = $("#slt_estados option:selected").val();
        var cidade = $("#slt_cidades option:selected").val();

        if (estado == "") {
            getLojas(PAGE, PAGE_ITENS);
        } else {
            if (cidade != "") {
                getLojas(PAGE, PAGE_ITENS, estado, cidade);
            } else {
                getLojas(PAGE, PAGE_ITENS, estado);
            }
        }


    });










    // MOBILE \\
    $('.hamburguer').on("click", function() {

        $('nav.nav-lateral-mobile').removeClass('hidden').toggleClass("mostrar");
    });

    $('.cruz').on("click", function() {
        $('nav.nav-lateral-mobile').removeClass('mostrar').addClass('hidden');
    });



    //getLojas(PAGE, PAGE_ITENS);

});