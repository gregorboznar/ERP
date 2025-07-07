# Manufacturing ERP

A comprehensive ERP (Enterprise Resource Planning) system built with Laravel and Filament, designed for manufacturing companies to manage their core business processes efficiently.

## About The Project

This ERP application provides a centralized platform to manage various aspects of a manufacturing workflow, from materials and products to machine operations and quality control. The system is built on the robust Laravel framework, with a powerful and user-friendly admin interface created using Filament.

## Key Features

-   **Product Management**: Manage product catalog, details, and specifications.
-   **Material Receipts**: Track incoming materials and manage supplier receipts.
-   **Manufacturing Process Control**: Monitor and manage key manufacturing stages:
    -   Die Casting
    -   Grinding
    -   Machine Trimming
-   **Statistical Process Control (SPC)**: Record and analyze measurement data for quality assurance (`ScpMeasurement`).
-   **Maintenance**: Schedule and track maintenance for machinery and equipment (`MaintenancePoint`).
-   **Compliance**: Manage and ensure compliance with industry standards (`ConfirmationCompliance`).
-   **Tendering**: Handle series tenders and related processes.
-   **User Management**: Control access and permissions with a role-based system.
-   **Data Export**: Export data to spreadsheet formats for reporting and analysis.

## Tech Stack

-   **Backend**: PHP 8.2, Laravel 11
-   **Frontend**: Blade, Livewire
-   **Admin Panel**: Filament
-   **Database**: (MySQL, PostgreSQL, etc. - as configured in `.env`)
-   **Authentication & Authorization**: `spatie/laravel-permission`, `bezhansalleh/filament-shield`
-   **Excel Handling**: `phpoffice/phpspreadsheet`

## Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   A database server (e.g., MySQL, MariaDB, PostgreSQL)

### Installation

1.  **Clone the repository:**

    ```sh
    git clone https://github.com/your_username/your_repository.git
    cd your_repository
    ```

2.  **Install PHP dependencies:**

    ```sh
    composer install
    ```

3.  **Install NPM dependencies:**

    ```sh
    npm install && npm run build
    ```

4.  **Create your environment file:**

    ```sh
    cp .env.example .env
    ```

5.  **Generate an application key:**

    ```sh
    php artisan key:generate
    ```

6.  **Configure your `.env` file:**
    Update the `DB_*` variables with your database credentials.

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Run database migrations:**
    ```sh
    php artisan migrate
    ```

## Database Seeding

To populate the database with initial data, you can use the provided seeders.

Run the main seeder:

```sh
php artisan db:seed
```

To run a specific seeder (e.g., for the admin user):

```sh
php artisan db:seed --class=CreateSuperAdminSeeder
```

## Usage

Start the local development server:

```sh
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`. The Filament admin panel is typically available at `/admin`.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
