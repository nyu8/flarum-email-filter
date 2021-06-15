<?php

namespace NYU8\FlarumEmailFilter;

use Flarum\Foundation\ValidationException;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use NYU8\FlarumEmailFilter\Rule;

class EmailCustomValidator
{
  /**
   * @var SettingsRepositoryInterface
   */
  protected $settings;

  /**
   * @var Translator
   */
  protected $translator;

  public function __construct(SettingsRepositoryInterface $settings, Translator $translator)
  {
    $this->settings = $settings;
    $this->translator = $translator;
  }

  /**
   * @param Rule[] $rules
   */
  private static function checkRegex(string $email, array $rules)
  {
    foreach ($rules as $rule) {
      if (preg_match('/' . $rule->value . '/', $email, $_match)) {
        return true;
      }
    }

    return false;
  }

  /**
   *
   * @param Rule[] $rules
   */
  private static function checkLiteral(string $email, array $rules)
  {
    foreach ($rules as $rule) {
      if ($email == $rule->value) {
        return true;
      }
    }

    return false;
  }
}
