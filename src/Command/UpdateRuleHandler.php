<?php

namespace NYU8\FlarumEmailFilter\Command;

use Illuminate\Support\Arr;
use NYU8\FlarumEmailFilter\Rule;
use NYU8\FlarumEmailFilter\RuleValidator;

class UpdateRuleHandler
{
  /**
   * @var RuleValidator
   */
  protected $validator;

  public function __construct(RuleValidator $validator)
  {
    $this->validator = $validator;
  }

  public function handle(UpdateRule $command)
  {
    $actor = $command->actor;
    $data = $command->data;

    $attributes = Arr::get($data, 'attributes', []);
    $validate = [];

    $actor->assertAdmin();

    /**
     * @var Rule
     */
    $rule = Rule::query()->where('id', $command->ruleId)->firstOrFail();

    if (isset($attributes['name']) && $attributes['name']) {
      $validate['name'] = $attributes['name'];
      $rule->updateName($attributes['name']);
    }

    if (isset($attributes['value']) && $attributes['value']) {
      $validate['value'] = $attributes['value'];
      $rule->updateValue($attributes['value']);
    }

    if (isset($attributes['active'])) {
      $validate['active'] = $attributes['active'];
      $rule->updateActive($attributes['active']);
    }

    $this->validator->assertValid(array_merge($rule->getDirty(), $validate));
    $rule->save();

    return $rule;
  }
}
