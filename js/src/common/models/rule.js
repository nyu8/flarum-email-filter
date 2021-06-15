import Model from 'flarum/common/Model';

export default class Rule extends Model {
  ruleType = Model.attribute('ruleType');
  name = Model.attribute('name');
  value = Model.attribute('value');
  active = Model.attribute('active');
}
