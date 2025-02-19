<?php

require_once 'BancoDados/AgendamentosModel.php';

class Agendamentos
{
    private $agendamentos;

    public function __construct()
    {
        $this->agendamentos = new AgendamentosModel("parametrizador_horarios");
    }

    public function montarOptionProcedimento()
    {
        $procedimentos = $this->agendamentos->montarOptionProcedimento();

        print_r(json_encode($procedimentos));

    }

    public function buscarHorarioPorData($dados)
    {
        $horariosParametrizados = $this->agendamentos->carregarHorariosParametrizados();
        $diaSemana = $this->validarDiaSemana($horariosParametrizados['dataEspecifica'], $dados['dataSelecionada']);

        $parametros = ($diaSemana === "dataEspecifica")
            ? $horariosParametrizados['dataEspecifica'][$dados['dataSelecionada']]
            : $horariosParametrizados[$diaSemana];

        $arrayHorariosDisponiveis = $this->formatarArrayHorarios(
            $parametros['horaInicio'],
            $parametros['horaFim'],
            $parametros['intervalo'],
            $dados['dataSelecionada']
        );

        print_r(json_encode(array_values($arrayHorariosDisponiveis)));
    }

    private function validarDiaSemana($arrayDataEspecifica, $dataSelecionada)
    {
        if (array_key_exists($dataSelecionada, $arrayDataEspecifica)) {
            return 'dataEspecifica';
        }

        $arrayDiaSemana = ["domingo", "segunda", "terça", "quarta", "quinta", "sexta", "sabado"];
        $idDiaSemana = (new DateTime($dataSelecionada))->format("w");

        return ($arrayDiaSemana[$idDiaSemana] === "sabado") ? "sabado" : 
               (($arrayDiaSemana[$idDiaSemana] === "domingo") ? "domingo" : "segundaSexta");
    }

    private function formatarArrayHorarios($horaInicio, $horaFim, $intervalo, $dataSelecionada)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $horaInicio = strtotime($horaInicio);
        $horaFim = strtotime($horaFim);
        $horaAtual = strtotime(date('H:i'));

        $arrayHorarios = [];

        while ($horaInicio < $horaFim) {

            if ($dataSelecionada !== date('Y-m-d') || $horaInicio >= $horaAtual) {
                $arrayHorarios[] = date('H:i', $horaInicio);
            }

            $horaInicio += $intervalo * 60;

        }

        return $arrayHorarios;
    }
}
