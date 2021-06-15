<?php

namespace NYU8\FlarumEmailFilter\Api\Controller;

use Flarum\Api\Controller\AbstractDeleteController;
use Flarum\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NYU8\FlarumEmailFilter\Command\DeleteRule;
use Psr\Http\Message\ServerRequestInterface;

class DeleteRuleController extends AbstractDeleteController
{
  /**
   * @var Dispatcher
   */
  protected $bus;

  public function __construct(Dispatcher $bus)
  {
    $this->bus = $bus;
  }

  protected function delete(ServerRequestInterface $request)
  {
    $actor = $request->getAttribute('actor');
    $ruleId = Arr::get($request->getQueryParams(), 'id');
    $this->bus->dispatch(new DeleteRule($actor, $ruleId));
  }
}
