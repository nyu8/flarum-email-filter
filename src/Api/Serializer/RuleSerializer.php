<?php

namespace NYU8\FlarumEmailFilter\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use InvalidArgumentException;
use NYU8\FlarumEmailFilter\Rule;

class RuleSerializer extends AbstractSerializer
{
  protected $type = 'email_rules';

  protected function getDefaultAttributes($rule)
  {
    if (!($rule instanceof Rule)) {
      throw new InvalidArgumentException(get_class($this) . ' can only serialize instances of ' . Rule::class);
    }

    return [
      'ruleType' => $rule->rule_type,
      'name' => $rule->name,
      'value' => $rule->value,
      'active' => $rule->active
    ];
  }
}
