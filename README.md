# Game Manager

Game Manager is an application designed to manage in-game markets and guilds. It's built
with [Laravel](https://laravel.com/), [Vue](https://vuejs.org/), and [Inertia.js](https://inertiajs.com/).

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Running the Tests](#running-the-tests)
- [API](#api)
- [Contributing](#contributing)
- [License](#license)
- [Authors](#authors)

## Installation

### Prerequisites

- PHP 8.2
- [Docker](https://www.docker.com/)
- [make](https://gnuwin32.sourceforge.net/packages/make.htm)

### Setup

1. Clone the repository:

```bash
git clone https://github.com/dicani0/game-manager
cd game-manager
```

Install the dependencies:

```bash
composer install
npm install
```

Copy the example environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

Start the containers:

```bash
make start
```

Enter the shell of the application container:

```bash
make bash
```

Run the migrations:

```bash
php artisan migrate:fresh --seed
```

Start the application:

```bash
npm run dev
```

Start the queue:

```bash
php artisan queue:work
```

## Running the tests

To run the tests use the following command:

```bash
php artisan test
```

# API

To be added

## Authors

[Dicanio](https://www.linkedin.com/in/dawid-miklas/)



