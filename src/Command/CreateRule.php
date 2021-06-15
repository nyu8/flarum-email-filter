<?php

namespace NYU8\FlarumEmailFilter\Command;

use Flarum\User\User;

class CreateRule
{
  /**
   * @var User
   */
  public $actor;
  /**
   * @var array
   */
  public $data;

  public function __construct(User $actor, array $data)
  {
    $this->actor = $actor;
    $this->data = $data;
  }
}
