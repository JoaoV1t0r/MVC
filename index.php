<?php

require __DIR__ . '/includes/app.php';

//INCLUI AS ROTAS DE PAGINAS
include __DIR__ . '/routes/pages.php';

$app->run()->sendResponse();
