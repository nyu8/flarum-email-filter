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

  public function validate(string $email)
  {
    $activeRules = Rule::all()->where('active', 1);
    $blacklistLiteralRules = $activeRules->where('rule_type', 3);
    $blacklisted = false;

    if (static::checkLiteral($email, $blacklistLiteralRules)) {
      $this->raiseBlacklistException();
    }

    $blackListRegexRules = $activeRules->where('rule_type', 4);

    if (static::checkRegex($email, $blackListRegexRules)) {
      $blacklisted = true;
    }

    $whiteListLiteralRules = $activeRules->where('rule_type', 1);
    $whiteListRegexRules = $activeRules->where('rule_type', 2);

    if ($blacklisted) {
      if (static::checkLiteral($email, $whiteListLiteralRules)) {
        return;
      } else {
        $this->raiseBlacklistException();
      }
    }

    if (count($whiteListLiteralRules) && count($whiteListRegexRules) === 0) {
      return;
    }

    if (static::checkLiteral($email, $whiteListLiteralRules) || static::checkRegex($email, $whiteListRegexRules)) {
      return;
    }

    $this->raiseWhitelistException();
  }

  private function raiseBlacklistException()
  {
    $message = $this->settings->get('nyu8-email-filter.custom_failure_message', $this->translator->trans('nyu8-email-filter.forum.blacklist_exception'));
    throw new ValidationException([$message]);
  }

  private function raiseWhitelistException()
  {
    $message = $this->settings->get('nyu8-email-filter.custom_failure_message', $this->translator->trans('nyu8-email-filter.forum.whitelist_exception'));
    throw new ValidationException([$message]);
  }

  /**
   * @param Rule[] $rules
   */
  private static function checkRegex(string $email, mixed $rules)
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
  private static function checkLiteral(string $email, mixed $rules)
  {
    foreach ($rules as $rule) {
      if ($email == $rule->value) {
        return true;
      }
    }

    return false;
  }
}
