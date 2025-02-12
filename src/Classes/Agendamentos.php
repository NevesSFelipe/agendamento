<?php
    
    require_once 'BancoDados/AgendamentosModel.php';

    class Agendamentos {

        private $agendamentos;

        public function __construct()
        {
            $this->agendamentos = new AgendamentosModel("parametrizador_horarios");
        }

        public function carregarHorariosParametrizados()
        {
            $this->agendamentos->carregarHorariosParametrizados();
        }

    }