# The Liverpool Offside

A dedicated fanpage for Liverpool FC supporters, built to demonstrate a robust, secure, and modern authentication system using native PHP.

**Project Goal:** To master backend authentication workflows in PHP without relying on heavy frameworks like Laravel. This includes handling sessions, secure password hashing, OAuth (Google), and email-based password resets.

## Features

### Authentication & Security

-   **User Signup & Login:**
-   **Password Hashing:**
-   **Google OAuth 2.0:**
-   **Persistent Login:**
-   **Input Sanitization:**
-   **Session Management:**

### Account Recovery

-   **Forgot Password:** Generates unique, time-sensitive tokens for password resets.
-   **Email Delivery:** Integrated **PHPMailer** with SMTP to send real emails to users.
-   **Token Expiry:** Reset links expire automatically after 30 minutes for security.

### Frontend

-   **Tailwind CSS:** Fully responsive, modern UI with Liverpool FC branding.
-   **Interactive Forms:** Real-time error feedback

## Tech Stack

-   **Backend:** PHP 8+
-   **Database:** MySQL (via XAMPP)
-   **Frontend:** HTML5, Tailwind CSS
-   **Dependencies:**
    -   `vlucas/phpdotenv` for env variable management
    -   `google/apiclient` for Google OAuth
    -   `phpmailer/phpmailer` for SMTP Emailing
-   **Tools:** Composer, Git

---

## Installation & Setup

### 1. Prerequisites

-   **XAMPP** (or any PHP/MySQL server environment).
-   **Composer** (PHP Package Manager).

### 2. Clone the Repository

````bash
### 2. Cloning the Repository
```bash
git clone [https://github.com/thatguy-git/Auth-system-for-Football-Fan-Page.git](https://github.com/thatguy-git/Auth-system-for-Football-Fan-Page.git) liverpool-offside
cd liverpool-offside
````
