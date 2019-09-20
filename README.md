# CodeIgniter 4 Advanced Project Template

[Yii 2 Advanced Project Template](https://github.com/yiisoft/yii2-app-advanced) ported to CodeIgniter 4.

## Overview

  - Signup
  - Login
  - Logout
  - Email Confirmation
  - Password Reset
  - Contact Form

## Installation

`composer create-project denis303/codeigniter4-advanced-app --stability=dev`

## Setup

1. Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

2. Run `bower install` or extract `public_libs.zip` archive. 

3. Run `php spark migrate -all`.

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
