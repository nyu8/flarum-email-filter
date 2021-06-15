<?php

namespace NYU8\FlarumEmailFilter\Command;

use NYU8\FlarumEmailFilter\Rule;

class DeleteRuleHandler
{
  public function handle(DeleteRule $command)
  {
    $actor = $command->actor;
    $actor->assertAdmin();

    $rule = Rule::query()->where('id', $command->ruleId)->firstOrFail();
    $rule->delete();

    return $rule;
  }
}
