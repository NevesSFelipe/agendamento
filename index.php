<?php date_default_timezone_set('America/Sao_Paulo'); ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Thais Alves | Agendamentos</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    </head>

    <body>
        <div class="container mt-3">
            <div class="">
                <h3 class="text-center mb-3">Agendamento</h3>

                <div class="container mt-4">
                    <div class="row">
                        <!-- Formulário de Agendamento -->
                        <div class="col-md-6">
                            <div class="card p-4 shadow-sm">

                                <div class="input-group mb-3">
                                    <input type="text" id="idCliente" value="1" class="form-control" />
                                </div>

                                <label class="mb-3">Selecione o Procedimento:</label>
                                <div class="input-group mb-3">
                                    <select class="form-control" name="" id="procedimentos"></select>
                                </div>

                                <label class="mb-3">Selecione a Data</label>
                                <div class="input-group mb-3">
                                    <input type="date" min="<?= date('Y-m-d') ?>" id="dataAgendamento" class="form-control" />
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="buscarHorarios"><i class="fas fa-search"></i> 🔍</button>
                                    </div>
                                </div>

                                <!-- Botões de Horários Disponíveis -->
                                <div id="horarios" class="d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        <!-- Ficha de Agendamento -->
                        <div class="col-md-6">
                            <div class="card p-4 shadow-sm">
                                <h4 class="text-center mb-3">Ficha de Agendamento</h4>

                                <p><strong>Cliente:</strong> <span id="clienteNome">Felipe Neves</span></p>
                                <p><strong>Procedimento:</strong> <span id="fichaProcedimento">--</span></p>
                                <p><strong>Valor:</strong> R$ <span id="fichaValor">--</span></p>
                                <p><strong>Data:</strong> <span id="fichaData">--</span></p>
                                <p><strong>Horário:</strong> <span id="fichaHorario">--</span></p>

                                <button class="btn btn-success btn-block mt-3" id="confirmarAgendamento">Confirmar Agendamento</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script type="module" src="assets/js/main.js?v=<?= time() ?>"></script>
    </body>
</html>