import app from 'flarum/admin/app';

import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import Button from 'flarum/common/components/Button';
import Switch from 'flarum/common/components/Switch';

import {settings} from '@fof-components';

import {Storage} from './storage';
import {getStorageKeys} from '../utils';

const {
  items: {StringItem},
} = settings;

export default class EmailFilterSettingsPage extends ExtensionPage {
  oninit(vnode) {
    super.oninit(vnode);
    this.setting = this.setting.bind(this);
    this.storage = new Storage(() => {
      m.redraw();
    });
  }

  content() {
    return (
      <div className="container">
        <div className="EmailFilterSettingsPage">
          <div className="SettingsSection GeneralPreferences">
            <h3>{app.translator.trans('nyu8-email-filter.admin.general')}</h3>
            <div className="Form-group">
              <StringItem
                name="nyu8-email-filter.custom_failure_message"
                setting={this.setting}
                style="max-width: 500px"
              >
                {app.translator.trans(
                  'nyu8-email-filter.admin.custom_failure_message_label',
                )}
                <div class="hint">
                  {app.translator.trans(
                    'nyu8-email-filter.admin.custom_failure_message_hint',
                  )}
                </div>
              </StringItem>
            </div>
            {this.submitButton()}
          </div>
          <div className="SettingsSection RuleSettings">
            <h3>
              {app.translator.trans('nyu8-email-filter.admin.rule_settings')}
            </h3>
            {getStorageKeys().map(storageKey =>
              this.#getRuleSettings(storageKey),
            )}
          </div>
        </div>
      </div>
    );
  }

  /**
   * @param {string} storageKey
   */
  #getRuleSettings(storageKey) {
    let extensionPrefix = `nyu8-email-filter.admin.${storageKey}`;

    return (
      <div className={`Rule-section settingsPage-${storageKey}`}>
        <legend>{app.translator.trans(`${extensionPrefix}.label`)}</legend>
        <div className="description">
          {app.translator.trans(`${extensionPrefix}.description`)}
        </div>
        <div className="rulesContainer">
          {this.#getExistingRuleSettings(storageKey, extensionPrefix)}
          {this.#getNewRuleSettings(storageKey, extensionPrefix)}
        </div>
      </div>
    );
  }

  /**
   * @param {string} storageKey
   * @param {string} extensionPrefix
   */
  #getExistingRuleSettings(storageKey, extensionPrefix) {
    return this.storage.getStorageRuleList(storageKey).map(rule => {
      let onActivitySwitch = () => {
        this.storage.toggleRuleActivity(rule);
      };

      let onNameInput = event => {
        this.storage.updateRuleName(rule, event.target.value);
      };

      let onValueInput = event => {
        this.storage.updateRuleValue(rule, event.target.value);
      };

      /**
       * @param {string} attribute
       * @returns
       */
      let buildOnInputFinished = attribute => () => {
        try {
          this.storage.saveRule(rule, attribute);
        } catch (error) {
          if (String(error).includes('Invalid regular expression')) {
            app.alerts.show(
              {type: 'error'},
              app.translator.trans(
                'nyu8-email-filter.admin.invalid_regular_expression',
              ),
            );
          }
        }
      };

      let onDeleteButtonClick = () => {
        this.storage.removeRule(storageKey, rule);
      };

      return (
        <div className="Rules-existing">
          <Switch
            className="Rules-switch"
            state={rule.active()}
            onchange={onActivitySwitch}
          ></Switch>
          <input
            className="FormControl Rules-name"
            value={rule.name()}
            placeholder={app.translator.trans(
              'nyu8-email-filter.admin.name_placeholder',
            )}
            oninput={onNameInput}
            onblur={buildOnInputFinished('name')}
          ></input>
          <input
            className="FormControl Rules-value"
            value={rule.value()}
            placeholder={app.translator.trans(`${extensionPrefix}.placeholder`)}
            oninput={onValueInput}
            onblur={buildOnInputFinished('value')}
          ></input>
          <Button
            type="button"
            className="Button Button--icon no-label Rules-button"
            icon="fa fa-times"
            onclick={onDeleteButtonClick}
          ></Button>
        </div>
      );
    });
  }

  /**
   * @param {string} storageKey
   * @param {string} extensionPrefix
   */
  #getNewRuleSettings(storageKey, extensionPrefix) {
    let newRule = this.storage.getNewRule(storageKey);

    let onNameInput = event => {
      newRule.name = event.target.value;
    };

    let onValueInput = event => {
      newRule.value = event.target.value;
    };

    let onAddButtonClick = () => {
      try {
        this.storage.addRule(storageKey, newRule);
      } catch (error) {
        if (String(error).includes('Invalid regular expression')) {
          app.alerts.show(
            {type: 'error'},
            app.translator.trans(
              'nyu8-email-filter.admin.invalid_regular_expression',
            ),
          );
        }
      }
    };

    return (
      <div className="Rules-new">
        <input
          className="FormControl Rules-name"
          value={newRule.name}
          placeholder={app.translator.trans(
            'nyu8-email-filter.admin.name_placeholder',
          )}
          oninput={onNameInput}
        ></input>
        <input
          className="FormControl Rules-value"
          value={newRule.value}
          placeholder={app.translator.trans(`${extensionPrefix}.placeholder`)}
          oninput={onValueInput}
        ></input>
        <Button
          type="button"
          className="Button Button--warning no-label Rules-button"
          icon="fa fa-plus"
          onclick={onAddButtonClick}
        ></Button>
      </div>
    );
  }
}
