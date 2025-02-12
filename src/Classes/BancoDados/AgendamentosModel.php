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

        echo json_encode($dados);
    }

}