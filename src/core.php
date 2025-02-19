<?php

    require_once 'Classes/Agendamentos.php';

    $dados = recuperDadosRequest();
    $agendamentos = new Agendamentos;

    if( $dados['acaoAjax'] === "buscarHorarioPorData" ) { return $agendamentos->buscarHorarioPorData($dados); }
    if( $dados['acaoAjax'] === "montarOptionProcedimento" ) { return $agendamentos->montarOptionProcedimento(); }
    if( $dados['acaoAjax'] === "salvarAgendamento" ) { return $agendamentos->salvarAgendamento($dados); }
    
    function recuperDadosRequest() {

        if( $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            $json = file_get_contents('php://input');
            $dados = json_decode($json, true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
             
                http_response_code(400);
                echo json_encode(["error" => "Erro ao processar os dados JSON."]);
                exit;
            
            }

            return $dados;
    
        }

        return $_REQUEST;
    }