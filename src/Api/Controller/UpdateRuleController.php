<?php

namespace NYU8\FlarumEmailFilter\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NYU8\FlarumEmailFilter\Api\Serializer\RuleSerializer;
use NYU8\FlarumEmailFilter\Command\UpdateRule;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateRuleController extends AbstractShowController
{
  public $serializer = RuleSerializer::class;

  /**
   * @var Dispatcher
   */
  protected $bus;

  public function __construct(Dispatcher $bus)
  {
    $this->bus = $bus;
  }

  protected function data(ServerRequestInterface $request, Document $document)
  {
    $actor = $request->getAttribute('actor');
    $ruleId = Arr::get($request->getQueryParams(), 'id');
    $data = Arr::get($request->getParsedBody(), 'data', []);
    return $this->bus->dispatch(
      new UpdateRule($actor, $ruleId, $data)
    );
  }
}
