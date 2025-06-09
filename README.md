# pizza-place-sales

### Prerequisites:
Install the latest [composer](https://getcomposer.org/download/) and [docker](https://docs.docker.com/get-started/get-docker/).

---

### 1. Install project dependencies

```sh
  composer install
 ```

### 2. Copy .env file

```sh
  cp .env.example .env
 ```

### 3. Build laravel sail containers

```sh
  ./vendor/bin/sail up -d
 ```

### 4. Generate application key and run migrations

```sh
  ./vendor/bin/sail artisan key:generate
 ```

### 5. Generate application key and run migrations

```sh
  ./vendor/bin/sail artisan migrate:fresh --seed
 ```

### 6. Compile assets

```sh
  ./vendor/bin/sail yarn install
 ```

### 7. Run dev server

```sh
  ./vendor/bin/sail yarn dev
 ```