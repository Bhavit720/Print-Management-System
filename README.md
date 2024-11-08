# Print Management System

A comprehensive web application designed to streamline and manage print jobs with distinct admin and user roles. Built with PHP, HTML, CSS, JavaScript, and MySQL, this system allows administrators to oversee print requests, manage users, and set print limitations, while users can easily submit, track, and recharge for print jobs.

## Features

### Admin
- **User Management**: Add, view, or delete users and manage login credentials.
- **Print Control**: Approve or disapprove user print requests.
- **Print Limit Settings**: Set print cost and daily print page limits.

### User
- **Print Submission**: Upload and submit documents for printing.
- **Tracking**: View the status of submitted print jobs.
- **Wallet Recharge**: Manage account balance for print jobs.

## Project Structure
The project is organized as follows:
- `/css/` - Contains CSS files for styling.
- `/js/` - JavaScript files for interactive functionalities.
- `/admin/`, `/user/`, `/release-station/` - Pages for each role.
- Core files include `login.php`, `register.php`, `dashboard.php`, `upload.php`, `recharge.php`, `approve-print-job.php`, `db.php`, `logout.php`.

## Database
- MySQL database with tables for users, print jobs, and settings (configurations like print costs and page limits).

## Setup
1. **Requirements**: PHP, MySQL, and XAMPP.
2. **Installation**: Clone the repository, set up the database, and update connection settings in `db.php`.

## License
This project is licensed under the MIT License.

--- 

**Note**: The application aims to enhance security, reduce print waste, and improve operational efficiency in managing print resources.
