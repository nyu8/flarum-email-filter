<?php

namespace NYU8\FlarumEmailFilter\Api\Controller;

use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Bus\Dispatcher;
use Illuminate\Support\Arr;
use NYU8\FlarumEmailFilter\Api\Serializer\RuleSerializer;
use NYU8\FlarumEmailFilter\Command\CreateRule;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateRuleController extends AbstractCreateController
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
    $data = Arr::get($request->getParsedBody(), 'data', []);
    return $this->bus->dispatch(new CreateRule($actor, $data));
  }
}
