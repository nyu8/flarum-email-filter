<?php

namespace NYU8\FlarumEmailFilter\Api\Controller;

use Flarum\Api\Controller\AbstractListController;
use NYU8\FlarumEmailFilter\Api\Serializer\RuleSerializer;
use NYU8\FlarumEmailFilter\Rule;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListRulesController extends AbstractListController
{
  public $serializer = RuleSerializer::class;

  protected function data(ServerRequestInterface $request, Document $document)
  {
    return Rule::all();
  }
}
