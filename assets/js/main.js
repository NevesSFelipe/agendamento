document.addEventListener("DOMContentLoaded", () => init());

async function init() {

    montarOptionProcedimento();
    preencherFichaAgendamento();
    buscarHorarioPorData();
}

function buscarHorarioPorData() {

    document.getElementById("buscarHorarios").addEventListener("click", function () {

        let dataSelecionada = document.getElementById("dataAgendamento").value;

        if( dataSelecionada == "" ) {
            alert("Por favor, selecione uma data!");
            return;
        }

        document.getElementById("fichaData").innerText = dataSelecionada;

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
        
            html += `<option data-preco="${procedimento.preco}" value="${procedimento.nome}">${procedimento.nome}</option>`;
            
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