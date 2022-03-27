   
    
$(document).ready(function () {

    //################################# CARREGAR PACIENTES  - PAINEL MÉDICO ############################################

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('select[name="lista_paciente"]').on('change', function () {

        var usuario_id = $(this).val();
        console.log("Usuario" + usuario_id);

        $.ajax({
            type: 'GET',
            url: '/painelMedico/pegarUsuario/' + usuario_id,
            dataType: 'json',
            success: function (data) {

                console.log(data);

                // $('select[name=plano]').empty();
                $.each(data, function (key, value) {

                    $('#cpf').val(value.cpf);
                    $('#convenio').val(value.convenio_id);
                    $('#data_nascimento').val(value.data_nascimento);
                    $('#plano').val(value.plano_id);
                  
                })
            }, error: function () {
                console.log("Erro" + data);
            }

        })

    });


    //Mascaras

    $('.cpf').mask('000.000.000-00', {reverse: true});

    //Realizar upload da imagem do perfil do usuário

    $(":file").change(function(e){
        $("[name=form_uploadPicture]").trigger('submit');
   });
   
    //################################# FUNÇÃO PARA RESET MODAL ############################################
        $('.modal').on('hidden.bs.modal', function () {
            $(this)
                .find("input:not([type=hidden]),textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
                $("#msgValidacaoAdicionar").remove();
                $("#msgValidacaoEditar").remove();
                location.reload();
        });
    
    //################################# FILTRO PARA CAMPO SELECT CONVENIO x PLANOS ############################################
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
    
        $('select[name="convenio"]').on('change', function () {
    
            var convenio_id = $(this).val();
            console.log(convenio_id);
    
            $.ajax({
                type: 'GET',
                url: '/cadastrarUsuarios/pegarPlanos/' + convenio_id,
                dataType: 'json',
                success: function (data) {
    
                    console.log(data);
    
                    $('select[name=plano]').empty();
                    $.each(data, function (key, value) {
    
                        $('select[name=plano]').append('<option value="' + value.plano_id + '">' + value.descricao + '</option>');
    
                    })
                }, error: function () {
                    $('select[name=plano]').empty();
                    console.log("Erro" + data);
                }
    
            })
    
        });
    });
   
    
    //################################# CAMPO PERFIL ############################################
    function verificaPerfil(value) {
        var funcao = document.getElementById("funcao");
        var CRM = document.getElementById("crm");
        var convenio = document.getElementById("convenio");
        var plano = document.getElementById("plano");
    
        if (value == "F") {
            funcao.disabled = false;
            CRM.disabled = true;
            convenio.disabled = true;
            plano.disabled = true;
            CRM.value = ("");
            convenio.value = ("");
            plano.value = ("");
        } else if (value == "M") {
            CRM.disabled = false;
            funcao.value = ("");
            convenio.value = ("");
            plano.value = ("");
            funcao.disabled = true;
            convenio.disabled = true;
            plano.disabled = true;
        } else if (value == "P") {
            funcao.disabled = true;
            CRM.disabled = true;
            funcao.value = ("");
            CRM.value = ("");
            convenio.disabled = false;
            plano.disabled = false;
        } else if (value == "") {
            funcao.disabled = true;
            CRM.disabled = true;
            convenio.disabled = true;
            plano.disabled = true;
            funcao.value = ("");
            CRM.value = ("");
            convenio.value = ("");
            plano.value = ("");
    
        }
    };
    
    //################################# CEP ############################################
    
    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('endereco').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('cidade').value = ("");
        document.getElementById('uf').value = ("");
    
    }
    
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value = (conteudo.logradouro);
            document.getElementById('bairro').value = (conteudo.bairro);
            document.getElementById('cidade').value = (conteudo.localidade);
            document.getElementById('uf').value = (conteudo.uf);
    
            document.getElementById('CEPResponse').innerHTML = '';
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            document.getElementById('CEPResponse').innerHTML = '<span style="color:red">CEP não encontrado.</span>';
            if (el.value == '') document.getElementById('CEPResponse').innerHTML = '';
        }
    }
    
    function pesquisacep(valor) {
    
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
    
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
    
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
    
            //Valida o formato do CEP.
            if (validacep.test(cep)) {
    
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('uf').value = "...";
    
                document.getElementById('CEPResponse').innerHTML = '';
    
                //Cria um elemento javascript.
                var script = document.createElement('script');
    
                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
    
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
    
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                document.getElementById('CEPResponse').innerHTML = '<span style="color:red">CEP não encontrado.</span>';
    
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
    
    //################################# Telefone ############################################
    function mask(o, f) {
        setTimeout(function () {
            var v = mphone(o.value);
            if (v != o.value) {
                o.value = v;
            }
        }, 1);
    }
    
    function mphone(v) {
        var r = v.replace(/\D/g, "");
        r = r.replace(/^0/, "");
        if (r.length > 10) {
            r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
            r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
            r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            r = r.replace(/^(\d*)/, "($1");
        }
        return r;
    }
    
    
    //################################# DATA NASCIMENTO ############################################
    function mascara_data(campo, valor) {
        var mydata = '';
        mydata = mydata + valor;
        if (mydata.length == 2) {
            mydata = mydata + '/';
            campo.value = mydata;
        }
        if (mydata.length == 5) {
            mydata = mydata + '/';
            campo.value = mydata;
        }
    }
    
    //################################# CPF ############################################
    function is_cpf(c) {
    
        if ((c = c.replace(/[^\d]/g, "")).length != 11)
    
            return false
    
        if (c == "00000000000" ||
            c == "11111111111" ||
            c == "22222222222" ||
            c == "33333333333" ||
            c == "44444444444" ||
            c == "55555555555" ||
            c == "66666666666" ||
            c == "77777777777" ||
            c == "88888888888" ||
            c == "99999999999")
            return false;
    
        var r;
        var s = 0;
    
        for (i = 1; i <= 9; i++)
            s = s + parseInt(c[i - 1]) * (11 - i);
    
        r = (s * 10) % 11;
    
        if ((r == 10) || (r == 11))
            r = 0;
    
        if (r != parseInt(c[9]))
            return false;
    
        s = 0;
    
        for (i = 1; i <= 10; i++)
            s = s + parseInt(c[i - 1]) * (12 - i);
    
        r = (s * 10) % 11;
    
        if ((r == 10) || (r == 11))
            r = 0;
    
        if (r != parseInt(c[10]))
            return false;
    
        return true;
    }
    
    
    function fMasc(objeto, mascara) {
        obj = objeto
        masc = mascara
        setTimeout("fMascEx()", 1)
    }
    
    function fMascEx() {
        obj.value = masc(obj.value)
    }
    
    function mCPF(cpf) {
        cpf = cpf.replace(/\D/g, "")
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
        return cpf
    }
    
    cpfCheck = function (el) {
        document.getElementById('cpfResponse').innerHTML = is_cpf(el.value) ? '<span style="color:green">Válido</span>' : '<span style="color:red">Inválido</span>';
        if (el.value == '') document.getElementById('cpfResponse').innerHTML = '';
    }