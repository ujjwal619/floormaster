# Laravel Scaffolding

Basic Scaffolding of laravel for medium to large scale laravel app.

# Installation Guide

1) $ `composer install`
2) $ `cp .env.example .env`
3) $ `php artisan key:generate`
4) $ `php artisan migrate`
5) $ `php artisan db:seed`

## Folder Structure

```
-- app
   |-- Constants
   |-- Domain
       |-- Admin
           |-- Controllers
               |-- Dashboard
                   |-- DashboardController.php
           |-- Policies
           |-- Requests
               |-- Dashboard
                   |-- DashboardRequest.php
           |-- Services
               |-- Dashboard
                   |-- DashboardService.php
       |-- Api
           |-- Controllers
               |-- User
                   |-- UserController.php
           |-- Policies
           |-- Presenters
               |-- User
                   |-- UserPresenter.php
           |-- Requests
               |-- User
                   |-- UserRequest.php
           |-- Services
               |-- User
                   |-- UserService.php
           |-- Transformers
               |-- User
                   |-- UserTransformer.php
       |-- Console
       |-- Frontend
   |-- Infrastructure
       |-- Base
           |-- BaseController.php
           |-- BaseRepository.php
       |-- Broadcasting
       |-- Contracts
       |-- Events
       |-- Exceptions
           |-- Handler.php
       |-- Helpers
           |-- ViewHelpers
               |-- homepage.php
               |-- dashboard.php
           |-- helpers.php
       |-- Jobs
       |-- Kernels
           |-- HttpKernel.php
           |-- ConsoleKernel.php
       |-- Listeners
       |-- Mail
       |-- Middlerwares
           |-- EncryptCookies.php
           |-- RedirectIfAuthenticated.php
           |-- TrimStrings.php
           |-- TrustProxies.php
           |-- VerifyCsrfToken.php
       |-- Notifications
       |-- Providers
           |-- AppServiceProvider.php
           |-- AuthServiceProvider.php
           |-- BroadcastServiceProvider.php
           |-- EventServiceProvider.php
           |-- RouteServiceProvider.php
       |-- Rules
   |-- Models
       |-- Entitities
           |-- User
               |-- User.php
               |-- UserAccessor.php
               |-- UserMutator.php
       |-- Repositories
           |-- User
               |-- UserRepository.php
               |-- IUserRepository.php
       |-- Scopes
-- config
-- database
-- public
-- resources
-- routes
-- storage
-- tests
```
