<p align="center"><img src="https://i.imgur.com/TzbNrPm.png" width="400"></p>

## About
<p align="center"><img height="300" src="https://i.imgur.com/xpq47Ja.png"></p>
This is a demo implementation of a software that allows you to launch a rover into Mars and control it's movements. A mission is considered successful when it runs all the input commands  and does not encounter an obstacle or tries to access a coord out of the map's bounds.

## Considerations
- The available map is a square, 100x100 grid starting at x=0 y=0 (top-left corner) and ending
at x=99 y=99 (bottom-right corner). This is for front-end purposes (read below).
- The map is represented in a 600x600 px grid-like canvas where each square is 6x6 and represents a single coord (0,0).
- Bigger maps are supported but it's easier to represent a 600x600 canvas for this demo.
- Every time the rover turns right or left, we also update the orientation. Eg: If the rover is facing north and turns right, it's now facing east.
- Obstacles are generated randomly after the rover has been launched to a specific position.

## Installation

Clone the repository into your desired workspace.
```sh
git clone https://github.com/DvAlonso/MarsRover.git
```

Install the dependencies.
```sh
composer install
```


Copy .env.example into .env
```sh
cp .env.example .env
```

Within .env, change the following values to your database config.
```sh
DB_DATABASE=<yourdb>
DB_USERNAME=<yourdb_username>
DB_PASSWORD=<yourdb_password>
```

Generate a key for this project.
```sh
php artisan key:generate
```

Refresh the configuration cache.
```sh
php artisan config:cache
```

Run the migrations
```sh
php artisan migrate
```

Configurate nginx, apache or your desired web server or even run artisan serve locally:
```sh
php artisan serve
```

## Usage

Navigate to the landing page of your project. In this landing page you can either run a new mission or review an existing mission. Missions are saved with it's state so you can leave and come back to them anytime.

#### Starting a new mission

When you start a new mission you can either input two coords (X,Y) within the 0 <= coord <= 99 range or leave blank for a randomly-generated starting point.

#### Previewing the mission map

Once you've launched the rover into mars, and after a short delay (I mean, we're communicating to mars...), you'll get a preview of the surroundings of the rover. You will also be sent the current orientation of the rover, again, randomly generated.

#### Inputting the movement commands

After you've carefully reviewed (I hope) the map of the mission, you can input the movement commands into the top-left textarea. Accepted commands are R (right) F (forward) and L (left). You can run any combination of those, eg: FRRFFFLFRFLRFRFLR - FFFFFFFFFFFLRRRRRRR etc.

#### Moving the rover

Once you've sent the commands to the rover and after a short processing delay (not really) you will receive a new map with the mission result that can be either:

- Completed
- Aborted (right before an obstacle or before exiting the map bounds)

In this map you'll be able to see the path travelled by the rover.

## License

The Mars Rover demo is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
