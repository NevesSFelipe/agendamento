document.addEventListener("DOMContentLoaded", () => init());

const horariosParametrizados = {
    segundaSexta: null,
    sabado: null,
    domingo: null,
    dataEspecifica: {}
};

async function init() {
    await buscarHorarios();
}

async function buscarHorarios() {
    try {
        const url = "src/core.php?acaoAjax=buscarHorarios";
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const retornoBD = await response.json();
        processarHorarios(retornoBD);
    } catch (error) {
        console.error("Erro ao buscar horários:", error);
    }
}

function processarHorarios(retornoBD) {

    const diasMap = {
        "segundaSexta": "segundaSexta",
        "sabado": "sabado",
        "domingo": "domingo"
    };

    retornoBD.forEach(({ dia_semana, horarios_parametrizados }) => {

        if( dia_semana == "dataEspecifica" ) {

            horarios_parametrizados.forEach(({ data, horaInicio, horaFim, intervalo }) => {
                horariosParametrizados.dataEspecifica[data] = {
                    horario: `${horaInicio}x${horaFim}`,
                    intervalo: intervalo
                };
            });

        }

        if (diasMap[dia_semana]) {
            horariosParametrizados[diasMap[dia_semana]] = {
                horario: `${horarios_parametrizados.horaInicio}x${horarios_parametrizados.horaFim}`,
                intervalo: horarios_parametrizados.intervalo
            };
        }
    });

    console.log(horariosParametrizados);
}