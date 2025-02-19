document.addEventListener("DOMContentLoaded", () => init());

async function init() {

    montarOptionProcedimento();
    preencherFichaAgendamento();
    buscarHorarioPorData();
    confirmarAgendamento();
}

function buscarHorarioPorData() {

    document.getElementById("buscarHorarios").addEventListener("click", function () {

        let dataSelecionada = document.getElementById("dataAgendamento").value;

        if( dataSelecionada == "" ) {
            alert("Por favor, selecione uma data!");
            return;
        }

        document.getElementById("fichaData").innerText = dataSelecionada;
        document.getElementById("fichaHorario").innerText = "";

        montarOptionHorarios(dataSelecionada);

    });

}

async function montarOptionProcedimento() {  

    try {
 
        const url = `src/core.php?acaoAjax=montarOptionProcedimento`;

        const response = await fetch(url);
        
        if (!response.ok) { throw new Error(`Erro na requisição: ${response.status}`); }

        const retornoBD = await response.json();

        let html = `<option disabled selected value="">Selecione um Procedimento</option>`;

        retornoBD.forEach(procedimento => {
        
            html += `<option data-preco="${procedimento.preco_procedimento}" value="${procedimento.id_procedimento}">${procedimento.nome_procedimento}</option>`;
            
        });        

        document.getElementById("procedimentos").innerHTML = html;

    } catch (error) {
        console.error("Erro ao buscar horários:", error);
    }
}

async function montarOptionHorarios(dataSelecionada) {  

    try {
 
        const url = `src/core.php?acaoAjax=buscarHorarioPorData&dataSelecionada=${dataSelecionada}`;

        const response = await fetch(url);
        
        if (!response.ok) { throw new Error(`Erro na requisição: ${response.status}`); }

        const retornoBD = await response.json();

        const horariosContainer = document.getElementById("horarios");
        horariosContainer.innerHTML = ""; // Limpa botões anteriores

        retornoBD.forEach(horario => {
           
            const button = document.createElement("button");
            button.className = "btn btn-outline-success m-1";
            button.innerText = horario;
        
            button.addEventListener("click", function () {
                document.getElementById("fichaHorario").innerText = horario;
        
                // Remove a classe "btn-success" e "text-light" de todos os botões
                document.querySelectorAll(".btn").forEach(btn => {
                    btn.classList.remove("btn-success", "text-light");
                    btn.classList.add("btn-outline-success");
                });
        
                // Adiciona a classe "btn-success" e "text-light" ao botão clicado
                button.classList.add("btn-success", "text-light");
                button.classList.remove("btn-outline-success");
            });
        
            horariosContainer.appendChild(button);
        });        

    } catch (error) {
        console.error("Erro ao buscar horários:", error);
    }
}

function preencherFichaAgendamento() {
 
    document.getElementById("procedimentos").addEventListener("change", function () {

        const selectProcedimento = document.getElementById("procedimentos");

        const opcaoSelecionada = selectProcedimento.options[selectProcedimento.selectedIndex];
        
        const valorOpcaoSelecionada = opcaoSelecionada.text;
        document.getElementById("fichaProcedimento").innerHTML = valorOpcaoSelecionada;

        const preco = opcaoSelecionada.getAttribute("data-preco");
        document.getElementById("fichaValor").innerHTML = preco;

    });

}

function confirmarAgendamento() {

    document.getElementById("confirmarAgendamento").addEventListener("click", function () {

        const clienteId = document.getElementById("idCliente").value;

        const data = document.getElementById("fichaData").textContent;
        if( data == "--" ) {
            alert('Escolha uma data');
            return;
        }

        const horario = document.getElementById("fichaHorario").textContent;
        if( horario == "--" ) {
            alert('Escolha um hoáario');
            return;
        }

        const procedimento = document.getElementById("procedimentos").value;
        alert(procedimento)
        if( procedimento == "" ) {
            alert('Selecione um procedimento');
            return;
        }

        const acaoAjax = "salvarAgendamento";
        const dadosAgendamento = { clienteId, data, horario, procedimento, acaoAjax };

        salvarAgendamento(dadosAgendamento);

    });

}

async function salvarAgendamento(dadosAgendamento) {
    try {
        const url = "src/core.php?";

        let response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dadosAgendamento) // Convertendo objeto JS para JSON
        });

        let data = await response.json();

        if (data.success) {
            alert("Agendamento salvo com sucesso!");
            location.reload();
        } else {
            alert("Erro: " + data.message);
        }
    } catch (error) {
        alert("Erro ao enviar os dados!");
    }
}
