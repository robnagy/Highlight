## Highlight

A simple todo list system that "highlights" the current task you're working on.
Supports multiple users, subtasks, and tags.
Written using Laravel 5.7 with a Vuejs 2 frontend.
This is a project I've used to gain a better personal understanding of how to implement SOLID principles, particularly when working with Laravel. 
* A Service layer implements business logic, and extends an Eloquent repository style class. I've avoided calling it a repository, as it uses Eloquent models throughout, so true abstraction hasn't been achieved. These are injected into Controllers and Policies via their respective Interfaces.
* User permission checking for various actions are defined in standard Laravel policies, though the authenticated user object is the only Eloquent model used. The policies are called from either controller methods for view operations, or Request authorize methods for write operations.
* All data validation done using Requests

The VueJS frontend was done in addition to this, to refresh my knowledge, but requires refactoring.

This is an ongoing project, with plenty more to do:
* Frontend styling redesign
* Date support for tasks, with imports of previous incomplete tasks
* Tag management page

### Requirements
- PHP 7.1
- Composer
- NPM

### Install
*Clone the repository
> git clone https://github.com/robnagy/Highlight.git
* Composer install
> composer install
* (Optional) Node packages install. Build files have been commited.
> npm install && npm run dist
* Add database credentials to .env
*Generate new app key 
> php artisan key:generate
* Run migrations and seed database
> php artisan migrate
> php artisan db:seed
* Launch server
> php artisan serve
