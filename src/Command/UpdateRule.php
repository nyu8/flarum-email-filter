<?php

namespace NYU8\FlarumEmailFilter\Command;

use Flarum\User\User;

class UpdateRule
{
  /**
   * @var User
   */
  public $actor;
  /**
   * @var int
   */
  public $ruleId;
  /**
   * @var array
   */
  public $data;

  public function __construct(User $actor, int $ruleId, array $data)
  {
    $this->actor = $actor;
    $this->ruleId = $ruleId;
    $this->data = $data;
  }
}
