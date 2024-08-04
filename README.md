# Opticonnect

Opticonnect is a management information system designed to monitor and manage Optical Line Terminals (OLTs) for Internet Service Providers (ISPs). The system provides real-time alerts, resource checks, and optimal team selection to ensure swift and efficient resolution of any OLT issues.

## Features

- **Real-time Alerts**: Immediate notifications for any OLT issues.
- **Resource Management**: Checks and allocates necessary resources for problem resolution.
- **Optimal Team Selection**: Ensures the best team is chosen based on the resources required and team availability.
- **Historical Data**: Stores and manages outage history for analysis and reporting.
- **User Management**: Handles user authentication and profile management.

## Technologies Used

- **Backend Framework**: [Laravel](https://laravel.com/)
- **Frontend Framework**: [React](https://reactjs.org/)
- **State Management**: [Inertia.js](https://inertiajs.com/)
- **Styling**: [Tailwind CSS](https://tailwindcss.com/)
- **Database**: Postgres (or any preferred database)
- **Deployment and Server Management**: [Laravel Forge](https://forge.laravel.com/)
- **Cloud Hosting**: [Digital Ocean](https://www.digitalocean.com/)

## Installation

### Prerequisites

Ensure you have the following installed:
- PHP >= 7.4
- Composer
- Node.js & npm
- Postgres (or any other preferred database)

### Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/opticonnect.git
   cd opticonnect
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```bash
   npm install
   ```

4. **Set up environment variables:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure the database:**
   Update the `.env` file with your database configuration. For SQLite, it should look something like this:
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=/path_to_your_database/database.sqlite
   ```

   If you don't have a SQLite database file, you can create one using:
   ```bash
   touch database/database.sqlite
   ```

6. **Run database migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

7. **Compile the assets:**
   ```bash
   npm run dev
   ```

## Running the Application

To start the development server, run the following command:
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser to view the application.

## Usage

### Generate an Outage

- Navigate to the dashboard and click the "Generate Outage" button. This will simulate an outage for a randomly selected OLT.

### Stop All Outages

- Click the "Stop All Outages" button to resolve all ongoing outages.

### View Data

- Navigate through the different sections (Teams, OLTs, Outages, Customers) to view and manage the respective data.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For any questions or feedback, please contact [yourname@example.com](mailto:yourname@example.com).

---

Thank you for using Opticonnect!
