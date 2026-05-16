<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  <h1>🧠 The Mind Board</h1>
  <p><em>A Revolutionary, Subscription-Gated Mental Health Platform</em></p>
</div>

---

## 📖 Overview

**The Mind Board** is an advanced, production-ready web application designed to disrupt the clinical, intimidating aesthetic of traditional therapy software. Built with an intentionally soothing, chaotic "doodle" design system using Tailwind CSS, it normalizes human emotion while delivering highly robust, complex backend architecture.

This project was built from the ground up using **Laravel 11**, **MongoDB**, and the **Google Gemini Artificial Intelligence API**.

---

## ✨ Core Features

### 📅 Smart Subscription-Gated Booking Engine
*   **Concurrency Locking:** Real-time database checks prevent "race conditions" where two users might book the exact same slot.
*   **Algorithmic Availability:** Dynamically subtracts booked slots from standard operating hours.
*   **Credit Refunds:** Full cancellation lifecycle management. Cancelling a session automatically refunds 1 credit to the user's subscription ledger.

### 🤖 AI Integration ("Dr. MindBoard")
*   Integrated with Google's **Gemini 2.5 Flash API**.
*   Uses asynchronous JavaScript (`fetch()`) to communicate with the AI in real-time without locking the PHP server.
*   Strict Prompt Engineering forces the AI to act as a supportive, empathetic, non-medical sounding board.

### ✉️ Two-Way Secure Messaging & RBAC
*   **Role-Based Access Control:** Separate portals for Patients and Therapists. 
*   **Therapist Portal:** A dedicated, hidden dashboard where professionals can view their daily schedule and reply securely to patient text logs.
*   **SMTP Notifications:** Automatically dispatches email alerts to the therapist's inbox when a new patient message arrives.

### 📈 Dynamic SVG Mood Graphing
*   Users log daily emotional states (Good, Okay, Bad).
*   The application mathematically generates a raw `<path d="M... C...">` string using **Bézier curves** to draw a continuous, wobbly mood graph dynamically in the browser—no third-party charting libraries required!

---

## 🛠️ Technology Stack

*   **Backend:** Laravel 11.x (PHP 8.2+)
*   **Database:** MongoDB v6.0+ (via `mongodb/laravel-mongodb`)
*   **Frontend Rendering:** Laravel Blade templating engine
*   **Styling:** Tailwind CSS (Utility-first framework)
*   **AI Engine:** Google Generative Language API
*   **Authentication:** Laravel Breeze (Bcrypt password hashing)

---

## 🚀 Installation & Local Development

### Prerequisites
You must have **PHP 8.2+**, **Composer**, **Node.js**, and a running **MongoDB** server installed on your machine. The PHP MongoDB extension (`mongodb.so` or `php_mongodb.dll`) must be enabled.

### Steps
1. **Clone the repository:**
   ```bash
   git clone https://github.com/kunal2tudu/the-mind-board-Mental-Health-Tracker-and-Therapy-Booking-System-.git
   cd "the-mind-board-Mental-Health-Tracker-and-Therapy-Booking-System-"
   ```

2. **Install PHP and Node dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure the Environment:**
   Copy the example `.env` file:
   ```bash
   cp .env.example .env
   ```
   Open the `.env` file and configure your API keys and MongoDB connection:
   ```env
   DB_CONNECTION=mongodb
   DB_DSN="mongodb://localhost:27017/"
   DB_DATABASE=the_mind_board

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_gmail
   MAIL_PASSWORD=your_app_password
   
   GEMINI_API_KEY=your_google_ai_key
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run the Development Servers:**
   Open two terminal windows.
   In Terminal 1 (Vite Asset Bundler):
   ```bash
   npm run dev
   ```
   In Terminal 2 (Laravel PHP Server):
   ```bash
   php artisan serve
   ```

6. **Access the application:**
   Navigate to `http://localhost:8000` in your web browser.

---

## 🛡️ Security Measures
*   **NoSQL Injection Prevention:** All MongoDB queries use Eloquent parameterized queries.
*   **Cross-Site Scripting (XSS):** Blade's `{{ }}` syntax escapes all database output.
*   **CSRF Protection:** All mutating routes (POST/PUT/DELETE) strictly enforce `@csrf` tokens linked to encrypted session cookies.

---

