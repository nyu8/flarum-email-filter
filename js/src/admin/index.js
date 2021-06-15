import app from 'flarum/admin/app';
import EmailFilterSettingsPage from './components/EmailFilterSettingsPage';
import Rule from '../common/models/rule';

app.initializers.add('nyu8-email-filter', () => {
  app.store.models.email_rules = Rule;

  app.extensionData
    .for('nyu8-email-filter')
    .registerPage(EmailFilterSettingsPage);
});
