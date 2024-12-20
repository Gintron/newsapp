# Project Setup Guide

Follow the steps below to set up the project locally:

## Prerequisites

Ensure you have the following installed:

1. [Docker](https://www.docker.com/) (for running Laravel Sail)
2. [Composer](https://getcomposer.org/) (PHP dependency manager)

---

## Step 1: Clone the Repository

First, clone the project repository to your local machine:

```bash
git clone https://github.com/Gintron/newsapp.git
cd newsapp
```

---

## Step 2: Install Dependencies

Run the following command to install PHP dependencies using Composer:

```bash
composer install
```

This command will install all required dependencies as defined in the `composer.json` file.

---

## Step 3: Start the Docker Containers

After installing Sail, start the Docker containers:

```bash
./vendor/bin/sail up
```

---

## Step 4: Set Up the Environment File

Copy the example `.env` file:

```bash
cp .env.example .env
```

Modify the `.env` and setup the following keys: ALGOLIA_APP_ID, ALGOLIA_SECRET, NEWSAPI_API_KEY, GUARDIAN_API_KEY, NEWYORKTIMES_API_KEY.

---

## Step 5: Generate the Application Key

Run the following command to generate the application key:

```bash
./vendor/bin/sail artisan key:generate
```

This will set the `APP_KEY` in the `.env` file.

---

## Step 6: Run Database Migrations

Run the migrations:

```bash
./vendor/bin/sail artisan migrate
```

---

## Step 7: Run the Scheduler

```bash
./vendor/bin/sail artisan schedule:run
```

---

## Step 8: Run the Queue

Run the queue so the news can be fetched.

```bash
./vendor/bin/sail artisan queue:work
```

---

## Step 9: Access the Application

You can now access the application in your browser at:

```
http://localhost
```

---

## Additional Commands

- To stop the Sail environment, use:

  ```bash
  ./vendor/bin/sail down
  ```

- To run other Artisan commands:

  ```bash
  ./vendor/bin/sail artisan <command>
  ```

---

## Troubleshooting

If you encounter any issues, ensure that:

1. Docker is running.
2. You have the correct permissions to execute scripts.
3. The `.env` file is properly configured.

