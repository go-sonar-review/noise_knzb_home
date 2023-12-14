## Checklist: Setting up a new project

When setting up a new project, make sure to complete all these steps

### GIT REPO
- [X] Create private git repository
- [X] For CI/CD purposes: Settings > Manage Access > Invite Team “noprotocol/deployments” read access
- [X] [Clone articulate-cms](https://github.com/noprotocol/articulate-cms) + push to master branch + push to develop branch + push to staging branch (depending on your git-flow)
- [X] acceptance as default branch

### HEROKU
- [X] Pipeline with staging and production app
- [X] buildpacks: PHP & NodeJS staging
- [ ] mandatory add-on: New Relic staging
- [X] buildpacks: PHP & NodeJS production
- [ ] mandatory add-on: New Relic production

### AWS Buckets [see here](#aws-bucket)
- [X] Bucket & User staging
- [X] Staging API keys in Heroku
- [X] Bucket & User production
- [X] Production API keys in Heroku
- [X] API Keys in OnePass

### RDS Database [see here](#rds-database)
- [X] Main user for client
- [X] Staging DB
- [X] Staging credentials in Heroku
- [X] Production DB
- [X] Production credentials in Heroku
- [X] Credentials in OnePass

### CI/CD [see here](#tokens-and-buddyworks)
- [ ] Semantic Release setup (GH_TOKEN & NPM_TOKEN in Buddy Works)
- [ ] Buddy Works pipeline Staging
- [ ] Buddy Works pipeline Production

### Site specific settings
- [ ] MultiLang -> setup sites&locales BEFORE adding entry types (timesaver)