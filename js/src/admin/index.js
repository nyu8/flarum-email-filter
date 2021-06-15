import app from 'flarum/admin/app';
import EmailFilterSettingsPage from './components/EmailFilterSettingsPage';

app.initializers.add('nyu8-email-filter', () => {
  console.log('Hello, email filter!');

  app.extensionData
    .for('nyu8-email-filter')
    .registerPage(EmailFilterSettingsPage);
});
