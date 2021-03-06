<?php

use Flarum\Extend;
use Flarum\User\Event\Saving;
use FoF\Components\Extend\AddFofComponents;
use NYU8\FlarumEmailFilter\Api\Controller\CreateRuleController;
use NYU8\FlarumEmailFilter\Api\Controller\DeleteRuleController;
use NYU8\FlarumEmailFilter\Api\Controller\ListRulesController;
use NYU8\FlarumEmailFilter\Api\Controller\UpdateRuleController;
use NYU8\FlarumEmailFilter\Event\UserSavingListener;

return [
  (new AddFofComponents()),
  (new Extend\Frontend('forum'))
    ->js(__DIR__ . '/js/dist/forum.js'),
  (new Extend\Frontend('admin'))
    ->js(__DIR__ . '/js/dist/admin.js')
    ->css(__DIR__ . '/less/admin.less'),
  (new Extend\Locales(__DIR__ . '/locale')),
  (new Extend\Routes('api'))
    ->get('/email_rules', 'email_rules.index', ListRulesController::class)
    ->post('/email_rules', 'email_rules.create', CreateRuleController::class)
    ->delete('/email_rules/{id}', 'email_rules.delete', DeleteRuleController::class)
    ->patch('/email_rules/{id}', 'email_rules.update', UpdateRuleController::class),
  (new Extend\Event)
    ->listen(Saving::class, UserSavingListener::class),
];
