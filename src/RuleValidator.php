<?php

namespace NYU8\FlarumEmailFilter;

use Flarum\Foundation\AbstractValidator;

class RuleValidator extends AbstractValidator
{
  protected $rule = [
    'rule_type' => ['required', 'integer'],
    'name' => ['required', 'string'],
    'value' => ['required', 'string'],
    'active' => ['required', 'integer']
  ];
}
