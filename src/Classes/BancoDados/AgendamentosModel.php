<?php

require_once 'Conexao.php';

class AgendamentosModel {

    private $conexao;
    private $tabela;

    public function __construct($tabela)
    {   
        $objConexao = new Conexao;
        $this->conexao = $objConexao->getConexao();

        $this->tabela = $tabela;
    }

    public function montarOptionProcedimento()
    {
        $sql = "SELECT * FROM procedimentos";
        $stmt = $this->conexao->prepare($sql);
        
        if( $stmt->execute() == false) { return []; }

        $resultado = $stmt->get_result();
        $dados = [];
        
        while ($row = $resultado->fetch_assoc()) {
            $dados[] = $row;
        }

        return $dados;
    }

    public function carregarHorariosParametrizados()
    {
        $sql = "SELECT * FROM $this->tabela";
        $stmt = $this->conexao->prepare($sql);
        
        if( $stmt->execute() == false) { return []; }

        $resultado = $stmt->get_result();
        $dados = [];
    
        while ($row = $resultado->fetch_assoc()) {

            if (isset($row['horarios_parametrizados'])) {
                $row['horarios_parametrizados'] = json_decode($row['horarios_parametrizados'], true);
            }

            $dados[] = $row;
        }

        return $this->hydrateHorariosParametrizados($dados);
    }

    private function hydrateHorariosParametrizados($horarioParametrizado)
    {

        $horarioParametrizadoTratado = array();

        foreach($horarioParametrizado as $parametro) {

            if( $parametro['dia_semana'] !== "dataEspecifica" ) {

                $horarioParametrizadoTratado[$parametro['dia_semana']] = array(
                    "horaInicio" => $parametro['horarios_parametrizados']['horaInicio'],
                    "horaFim" => $parametro['horarios_parametrizados']['horaFim'],
                    "intervalo" => $parametro['horarios_parametrizados']['intervalo'],
                );

            }

            if( $parametro['dia_semana'] === "dataEspecifica" ) {

                foreach( $parametro["horarios_parametrizados"] as $horarioEspecifico ) {

                    $horarioParametrizadoTratado['dataEspecifica'][$horarioEspecifico['data']] = array(
                      
                        "horaInicio" => $horarioEspecifico["horaInicio"],
                        "horaFim" => $horarioEspecifico["horaFim"],
                        "intervalo" => $horarioEspecifico["intervalo"]
                    
                    );

                }

            }

        }

        return $horarioParametrizadoTratado;

    }

}