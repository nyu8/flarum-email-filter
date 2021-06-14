<?php

use Flarum\Extend;

use FoF\Components\Extend\AddFofComponents;

return [
  (new AddFofComponents()),
  (new Extend\Frontend('forum'))
    ->js(__DIR__ . '/js/dist/forum.js'),
  (new Extend\Frontend('admin'))
    ->js(__DIR__ . '/js/dist/admin.js'),
];
