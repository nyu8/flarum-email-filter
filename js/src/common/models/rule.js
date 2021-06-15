import Model from 'flarum/common/Model';

export default class Rule extends Model {
  /**
   * @type {() => number}
   */
  ruleType = Model.attribute('ruleType');
  /**
   * @type {() => string}
   */
  name = Model.attribute('name');
  /**
   * @type {() => string}
   */
  value = Model.attribute('value');
  /**
   * @type {() => number}
   */
  active = Model.attribute('active');
}
