<?php

namespace NYU8\FlarumEmailFilter\Command;

use Flarum\User\User;

class DeleteRule
{
  /**
   * @var User
   */
  public $actor;
  /**
   * @var int
   */
  public $ruleId;

  public function __construct(User $actor, int $ruleId)
  {
    $this->actor = $actor;
    $this->ruleId = $ruleId;
  }
}
