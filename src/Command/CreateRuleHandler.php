<?php

namespace NYU8\FlarumEmailFilter\Command;

use Illuminate\Support\Arr;
use NYU8\FlarumEmailFilter\Rule;
use NYU8\FlarumEmailFilter\RuleValidator;

class CreateRuleHandler
{
  /**
   * @var RuleValidator
   */
  protected $validator;

  public function __construct(RuleValidator $validator)
  {
    $this->validator = $validator;
  }

  public function handle(CreateRule $command)
  {
    $actor = $command->actor;
    $data = $command->data;

    $actor->assertAdmin();

    $rule = Rule::build(
      Arr::get($data, 'attributes.ruleType'),
      Arr::get($data, 'attributes.name'),
      Arr::get($data, 'attributes.value'),
      Arr::get($data, 'attributes.active')
    );

    $this->validator->assertValid($rule->getAttributes());
    $rule->save();

    return $rule;
  }
}
