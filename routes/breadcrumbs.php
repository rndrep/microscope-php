<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Home > Blog
Breadcrumbs::for('map', function ($trail) {
    $trail->parent('home');
    $trail->push('info', route('map'));
});
