import Rule from '../src/common/models/rule';

declare global {
  interface StorageData {
    whitelist_literal: Rule[];
    whitelist_regex: Rule[];
    blacklist_literal: Rule[];
    blacklist_regex: Rule[];
  }

  interface NewRule {
    name: string;
    value: string;
  }

  interface NewRuleDict {
    whitelist_literal: NewRule;
    whitelist_regex: NewRule;
    blacklist_literal: NewRule;
    blacklist_regex: NewRule;
  }
}
