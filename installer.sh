#!/bin/bash

echo "Welcome to the Articulate installer!"

# Retrieve project details
echo "Project name:"
read project_name

echo "Your local url (e.g. http://project.test):"
read project_url

sed -i "" "s%_PROJECT_NAME_%$project_name%g" .env
sed -i "" "s%_PRIMARY_SITE_URL_%$project_url%g" .env

# Set up Craft
echo "Setting up Craft Project";

./craft setup/app-id
./craft setup/security-key
./craft setup/db-creds

# Generate a password for admin
ADMIN_PASSWORD=`openssl rand -base64 12`

# Install Craft CMS
./craft install --interactive=0 --email="info@noprotocol.nl" --username=noprotocol --password=$ADMIN_PASSWORD --siteName=$project_name  --language="nl-NL"

# Set the login credentials in the .env file
perl -pi -e "s/_ADMIN_USER_/noprotocol/g" .env
perl -pi -e "s/_ADMIN_PASSWORD_/$ADMIN_PASSWORD/g" .env

# Create sessions table
./craft setup/php-session-table

# Build the frontend
echo "Building Front-end";
yarn && yarn build

echo "Articulate for $project_name set up succesfully!"
echo ''
echo "You can find the credentials to log in to Craft CMS in the .env file"
echo ''
echo "Site: $project_url"
echo "CMS: $project_url/admin"
