# Original Articulate docs

## Articulate - Craft CMS on steroids

### Prerequisites

1. PHP >= 8.0
2. MySQL >= 8
3. Articulate has to be a known repository to composer:
   open `~/.composer/config.json` (if it doesn't exists, create it) and make sure it contains:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:noprotocol/articulate-cms.git"
    }
  ]
}
```

### Prepare a database

Create a new database and remember the credentials

### Create the new project

Run the following to create a new project folder

```bash
composer create-project --remove-vcs noprotocol/articulate-cms your-new-project-name
```

During the installation the installer will ask you for the database credentials and add them to the `.env` file.

The login details of the Craft Admin user can be found in the `.env` file at the bottom
