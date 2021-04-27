<?php

require __DIR__ . '/includes/app.php';

//INCLUI AS ROTAS DE PAGINAS
include __DIR__ . '/routes/pages.php';

//INCLUI AS ROTAS Do PAINEL
include __DIR__ . '/routes/admin.php';

$app->run()->sendResponse();
