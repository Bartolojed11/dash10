# Dash10 PHP Developer Test

This developer test revolves around a basic [Laravel](https://www.laravel.com) app that features two of the best sports of the world ... rugby and basketball! At least - it currently supports rugby, and your job in this test is to extend it to also feature basketball.

It currently pulls player data from a demo rugby API endpoint, and presents a profile card representing that player. Read more about this api, and other endpoints used in this test in the [api docs](./docs/api.md).

![All Blacks Screenshot](https://i.imgur.com/dddgt1D.png)

Once you setup this demo app (see instructions below) the URL to load this page will be `http://localhost/allblacks/1` - with the last number representing the player ID. Currently, to change the player you have to manually change the ID in the URL.

##### Images
Player images are named (lowercase) `$firstName-$lastName.png` (e.g. `aaron-smith.png`) and are stored in `public/images/players/allblacks/` for All Black players, and `public/images/players/nba/` for NBA players.

Team logos are stored under `public/images/teams/$team.png`.

##### Further help

There is [installation help](#installation-help) and a [code guide](#code-guide) at the end of this doc.

## Tasks

Below are a list of tasks for you to complete. You can complete as many as you want - obviously the more tasks you complete & the more complex they are, the better you will score. Some tasks are simple, while others are more complex. Some focus on backend skill, while others on frontend.

I encourage you to choose the more complex tasks you feel you are able to complete first to best showcase your skills and experience.

### Task 1: UI & Navigation
*Difficulty: low - medium.*

Upgrade the interface to provide the ability to navigate to other players. There are 8 players currently provided by the API (although you app should allow for this to change in future without breaking).

Implement the new navigation tabs in the below mockup. The small player tabs should represent the players directly before and after the current featured player. Clicking on them should request that player from the API & render their data into the view.

Navigation should be circular - if you reach the last player, show the first player next. And the opposite at the start - show the last player as previous.

- See the navigation on the right hand side of the mockup below.
- The current player should appear 'tab up' with the same colour background as the main card.
- Previous & next players should appear with the black background.
- Font is `18px` (`1.125rem`), and weight `700`.
![Nav Screenshot](https://user-images.githubusercontent.com/2694025/169527260-5000bd90-7200-437e-82eb-b445c28c231a.png)

### Task 2: Efficiency
*Difficulty: low-medium*
1. Improve the efficiency of the app so we don't have to request data from the API every single page load.

Extra for experts:
2. Update the app so you can change players without reloading the page when different players are loaded. Feel free to use whatever frontend frameworks you prefer (eg VueJS/React/JQuery etc), or plain javascript.

### Task 3: NBA is awesome!
*Difficulty: Complex*

It would be really cool to extend our app so it could load in NBA player information into the same template - but with a NBA feel to it.

To do this we are going to need to access other endpoints documented in the [api documentation](./docs/api.md) - the `nba.players` and `nba.stats` endpoints. FYI this demo api has players from `id`: `1` through to `7`.

To complete this task you need to come up with a tidy solution that allows our app to pull data from these different endpoints, combines the data into a suitable format and renders it through the same view (with minor color / style differences).

We really want to avoid code duplication (DRY code is good code!), so make sure to use the same view & you should also be able to use the same single controller class.

Here are some hints:
1. We really want our controller class to be able to request data from either API (rugby or basketball) in exactly the same way - and receive data in a reliable format from either API. That way we don't need to make big changes to our controller code. That complexity should be abstracted away in other classes.
2. Create a player class to represent your player data - forcing the API service class to output data in a strict format for our controller class to consume. This class should know how to do things like determine its image.
3. Pull out the API code from the controller into a service class (store it under an `\App\Api` namespace) which pulls data from the API & provides it to the controller.
  - Create a contract / interface (under `app/Contracts`) that the API class(es) must implement.
  - Ideally create an abstract class which implements the basic methods of the contract - avoiding the need to duplicate code in the different API class implementations.
4. Refactor the controller & view code so it outputs data from the player instance
5. Create a new NBA class which implements the contract and pulls data from the API endpoint, transforming it as required to output the format the controller expects.
6. Update / register routes to accept e.g. `/nba/5` to load from the NBA endpoints
7. Write tests to prove your code works including
  - Unit tests for each API class
  - Feature test for the updated NBA routes
  - Ensure existing tests still pass

You will need to tweak a few aspects of the view & CSS (see [code guide](#code-guide) for information on where they are kept) so that your output when in "nba mode" will look like this mockup. (Note: the side nav will only show if you've completed task 1).

![NBA Screenshot](https://user-images.githubusercontent.com/2694025/169531537-ad701a2d-91f2-46de-90d5-79b57b4dfa7c.png)

## Installation Help

This application is built on top of Laravel 9. If you haven't used Laravel before, its a great framework and is reasonably simple to use. There are [heaps of docs available](https://laravel.com/docs/9.x/) on the official website.

The most simple way of running later versions of Laravel are using [Laravel Sail](https://laravel.com/docs/9.x/sail) on top of [Docker Desktop](https://www.docker.com/products/docker-desktop/). To use this you will need docker installed. If you are on windows you'll also need WSL2 up & running too.

If you haven't used docker much I strongly encourage you to take the time to learn how to use it. Once you get the hang of it you'll wonder how you ever developed without it! There are some good instructions on [Laravel's installation guide](https://laravel.com/docs/9.x/installation). Note: you only need to follow up to where it tells you run a `curl` command to set up a new application.

If you prefer to use vagrant, there are installation instructions using [Laravel Homestead](https://laravel.com/docs/9.x/homestead). Alternatively set it up however you best prefer to do your development.

The main key requirements are:
- PHP 8.0 or 8.1
- Composer
- Ability to do HTTP / API request

### Install steps

Once you have downloaded this repository and have your development environment up & running you will need to:

1. Copy `.env.example` to `.env`, and update `API_KEY=few823mv__570sdd0342`. This will allow your API connections to access the API.
2. You'll need to run `composer install` from inside the project folder once you have downloaded this repo and have your development environment up & running. This will download all the dependencies.
3. If you're using docker / sail, run `vendor/bin/sail up -d` to bring up the container.

## Code guide

If you're not familiar with Laravel, that is OK. As a competent PHP programmer you should be able to find your way around with a few tips:

1. In laravel, URL's are mapped to a controller class function using *routes*.  The main route is registered in `routes/web.php`.
2. This route is mapped to execute the controller class stored in `app/Http/Controllers/PlayerController.php`. This class contains all the main logic.
3. Laravel uses a templating system called *blade* to render HTML. The view / HTML is stored in `resources/views/player.blade.php` which includes a layout stored in `resources/views/components/layout.blade.php`
4. CSS & Images are static files stored under the `public/` directory.

In Laravel, all main classes & logic should be stored under the `app/` folder.
# dash10
