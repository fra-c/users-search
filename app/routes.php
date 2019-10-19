<?php

use App\Action\UserSearchAction;

$app->get('/users', UserSearchAction::class);
