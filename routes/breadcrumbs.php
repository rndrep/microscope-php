<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Home > Info
Breadcrumbs::for('info', function ($trail, $params = null) {
    $trail->parent('home');
    if (empty($params)) {
        return;
    }
    ['routeName' => $routeName, 'itemId' => $itemId, 'itemName' => $itemName] = $params;
    if (empty($routeName)) {
        return;
    }
    if ($itemId && $itemName) {
        $trail->push($itemName, route($routeName, $itemId));
    } else {
        $trail->push($itemName);
    }
});

Breadcrumbs::for('microscope', function ($trail) {
    $trail->parent('info');
    $trail->push('Микроскоп');
});
