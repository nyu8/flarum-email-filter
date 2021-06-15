<?php

namespace NYU8\FlarumEmailFilter\Event;

use Flarum\Foundation\ValidationException;
use Flarum\Locale\Translator;
use Flarum\User\Event\Saving;
use Illuminate\Support\Arr;
use NYU8\FlarumEmailFilter\EmailCustomValidator;

class UserSavingListener
{
  /**
   * @var Translator
   */
  protected $translator;

  /**
   * @var EmailCustomValidator
   */
  protected $emailValidator;

  public function __construct(Translator $translator, EmailCustomValidator $emailValidator)
  {
    $this->translator = $translator;
    $this->emailValidator = $emailValidator;
  }

  public function handle(Saving $event)
  {
    $email = Arr::get($event->data, 'attributes.email');

    if (!$email) {
      throw new ValidationException($this->translator->trans('nyu8-email-filter.forum.generic_exception'));
    }

    $this->emailValidator->validate($email);
  }
}
