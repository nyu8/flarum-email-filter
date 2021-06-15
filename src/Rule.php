<?php

namespace NYU8\FlarumEmailFilter;

use Flarum\Database\AbstractModel;

/**
 * @property int $rule_type
 * @property string $name
 * @property string $value
 * @property int $active
 */
class Rule extends AbstractModel
{
  protected $table = 'email_rules';

  public static function build(int $ruleType, string $name, string $value, int $active)
  {
    $rule = new static();

    $rule->rule_type = $ruleType;
    $rule->name = $name;
    $rule->value = $value;
    $rule->active = $active;

    return $rule;
  }

  public function updateName(string $name)
  {
    $this->name = $name;

    return $this;
  }

  public function updateValue(string $value)
  {
    $this->value = $value;

    return $this;
  }

  public function updateActive(int $active)
  {
    $this->active = $active > 0 ? 1 : 0;

    return $this;
  }
}
