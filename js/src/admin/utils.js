const RULE_TYPE_TO_STORAGE_KEY = {
  1: 'whitelist_literal',
  2: 'whitelist_regex',
  3: 'blacklist_literal',
  4: 'blacklist_regex',
};

export function getStorageKeys() {
  return Object.values(RULE_TYPE_TO_STORAGE_KEY);
}

/**
 * @returns {StorageData}
 */
export function getDefaultStorageData() {
  let keys = getStorageKeys();

  let data = {};

  for (let key of keys) {
    data[key] = [];
  }

  return data;
}

/**
 * @returns {NewRuleDict}
 */
export function getDefaultNewRuleDict() {
  let keys = getStorageKeys();

  let data = {};

  for (let key of keys) {
    data[key] = {
      name: '',
      value: '',
    };
  }

  return data;
}

/**
 * @param {number} ruleType
 * @returns {string}
 */
export function ruleTypeToStorageKey(ruleType) {
  ruleType = String(ruleType);

  if (!(ruleType in RULE_TYPE_TO_STORAGE_KEY)) {
    throw new Error(`Invalid rule type: ${ruleType}`);
  }

  return RULE_TYPE_TO_STORAGE_KEY[ruleType];
}

/**
 * @param {string} key
 * @returns {number}
 */
export function storageKeyToRuleType(key) {
  let entries = Array.from(Object.entries(RULE_TYPE_TO_STORAGE_KEY));

  let entry = entries.find(entry => entry[1] === key);

  if (!entry) {
    throw new Error(`Invalid storage key: ${key}`);
  }

  return Number(entry[0]);
}

/**
 * @param {string} text
 */
export function checkRegexSyntax(text) {
  try {
    new RegExp(text);
  } catch (error) {
    return false;
  }

  return true;
}
