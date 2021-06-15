import app from 'flarum/admin/app';
import Rule from '../../common/models/rule';
import {
  checkRegexSyntax,
  getDefaultNewRuleDict,
  getDefaultStorageData,
  ruleTypeToStorageKey,
  storageKeyToRuleType,
} from '../utils';

export class Storage {
  data = getDefaultStorageData();
  newRules = getDefaultNewRuleDict();
  onStorageUpdate = undefined;

  constructor(onStorageUpdate) {
    if (onStorageUpdate) {
      this.onStorageUpdate = onStorageUpdate;
    }

    app.store.find('email_rules').then(this.loadRules);
  }

  /**
   * @param {string} storageKey
   * @returns {Rule[]}
   */
  getStorageRuleList(storageKey) {
    if (!(storageKey in this.data)) {
      throw new Error(`Invalid storage key: ${storageKey}`);
    }

    return this.data[storageKey];
  }

  /**
   * @param {Rule[]} rules
   */
  loadRules = rules => {
    for (let rule of rules) {
      let storageKey = ruleTypeToStorageKey(rule.ruleType());
      this.getStorageRuleList(storageKey).push(rule);
      this.#callUpdate();
    }
  };

  /**
   * @param {string} storageKey
   * @returns {NewRule}
   */
  getNewRule(storageKey) {
    if (!(storageKey in this.newRules)) {
      throw new Error(`Invalid storage key: ${storageKey}`);
    }

    return this.newRules[storageKey];
  }

  /**
   * @param {string} storageKey
   * @param {NewRule} newRule
   */
  addRule(storageKey, newRule) {
    if (storageKey.includes('regex') && !checkRegexSyntax(newRule.value)) {
      throw new Error('Invalid regular expression');
    }

    app.store
      .createRecord('email_rules')
      .save({
        ruleType: storageKeyToRuleType(storageKey),
        name: newRule.name,
        value: newRule.value,
        active: 1,
      })
      .then(rule => {
        newRule.name = '';
        newRule.value = '';
        this.getStorageRuleList(storageKey).push(rule);
        this.#callUpdate();
      });
  }

  /**
   * @param {string} storageKey
   * @param {Rule} rule
   */
  removeRule(storageKey, rule) {
    rule.delete();

    let ruleList = this.getStorageRuleList(storageKey);
    let index = ruleList.findIndex(item => item.data.id === rule.data.id);
    if (index < 0) {
      return;
    }
    ruleList.splice(index, 1);
  }

  /**
   * @param {Rule} rule
   * @param {string} name
   */
  updateRuleName(rule, name) {
    rule.pushAttributes({name});
  }

  /**
   * @param {Rule} rule
   * @param {string} value
   */
  updateRuleValue(rule, value) {
    rule.pushAttributes({value});
  }

  /**
   * @param {Rule} rule
   * @param {string|undefined} attribute
   */
  saveRule(rule, attribute) {
    if (attribute) {
      if (
        attribute === 'value' &&
        ruleTypeToStorageKey(rule.ruleType()).includes('regex')
      ) {
        let value = rule.value();
        if (!checkRegexSyntax(value)) {
          throw new Error('Invalid regular expression');
        }
      }
      rule.save({[attribute]: rule.attribute(attribute)});
    } else {
      rule.save(rule.data.attributes);
    }
  }

  /**
   * @param {Rule} rule
   */
  toggleRuleActivity(rule) {
    rule.save({
      active: 1 - rule.active(),
    });
  }

  #callUpdate() {
    if (!this.onStorageUpdate) {
      return;
    }

    this.onStorageUpdate();
  }
}
