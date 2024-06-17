# Opticonnect

Opticonnect is a management information system designed to monitor and manage Optical Line Terminals (OLTs) for Internet Service Providers (ISPs). The system provides real-time alerts, resource checks, and optimal team selection to ensure swift and efficient resolution of any OLT issues. It also tracks Service Level Agreement (SLA) compliance and customer notifications.

## Features

- Real-time monitoring of OLTs with visual alerts
- Detailed customer and outage information
- Optimal team selection based on priority and resource availability
- SLA tracking and compliance monitoring
- Customer notifications via SMS

## Technologies Used

- Laravel
- Inertia.js
- Vue.js
- MySQL

## Setup Instructions

### Prerequisites

- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/opticonnect.git
   cd opticonnect

2. **Install dependencies:**
    ```bash
    composer install
    npm install

3. **Create a new MySQL database:**
    ```sql
    CREATE DATABASE opticonnect;
    ```

4. **Copy the `.env.example` file to `.env` and update the database configuration:**
    ```bash
    cp .env.example .env
    ```

5. **Complie the assets:**
    ```bash
    npm run dev
    ```

6. **Serve the application:**
    ```bash
    php artisan serve
    ```


### MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
