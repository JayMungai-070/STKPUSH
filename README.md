# STKPUSH - M-Pesa STK Push Subscription Portal

A lightweight PHP web application for collecting subscription payments via **Safaricom M-Pesa STK Push** (Daraja API). Users select a package, enter their phone number, and receive a push prompt on their handset to complete payment.

## Features

- 📦 Subscription package selection (Basic, Premium, Enterprise)
- 📲 M-Pesa STK Push integration (Safaricom Daraja sandbox API)
- ✅ Phone number and amount validation
- 🔔 Real-time payment status modal
- 📝 Callback handling with transaction logging (`callback.log`, `transaction_status.log`)
- 💳 Responsive UI with animated transitions (Animate.css + Font Awesome)

## Tech Stack

| Layer      | Technology                          |
|------------|-------------------------------------|
| Backend    | PHP (cURL)                          |
| Frontend   | HTML, CSS, Vanilla JavaScript       |
| Payment    | Safaricom Daraja M-Pesa STK Push API|
| Server     | Apache (XAMPP / any LAMP stack)     |

## Project Structure

```
STKPUSH/
├── index.php              # Landing page with packages & payment form
├── process_payment.php    # Generates Daraja access token & sends STK Push
├── callback.php           # Receives M-Pesa async callback & logs results
└── assets/
    ├── css/style.css      # UI styling
    └── js/script.js       # Package selection & form submission logic
```

## Getting Started

### Prerequisites

- A local server with PHP and cURL enabled (e.g. [XAMPP](https://www.apachefriends.org/))
- A [Safaricom Daraja](https://developer.safaricom.co.ke/) account (sandbox or production)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/JayMungai-070/STKPUSH.git
   ```
2. Copy the project into your web root (e.g. `C:\xampp\htdocs\STKPUSH`).
3. Update the M-Pesa credentials in `process_payment.php`:
   - `CONSUMER_KEY`
   - `CONSUMER_SECRET`
   - `BUSINESS_SHORT_CODE`
   - `PASSKEY`
   - `CALLBACK_URL` (must be a publicly accessible HTTPS URL)
4. Start Apache and open: `http://localhost/STKPUSH`

### Testing (Sandbox)

The app is configured for the Daraja **sandbox** environment. Use a test M-Pesa number registered in the sandbox to receive the STK Push prompt.

## Payment Flow

```
User selects package → enters phone number
        ↓
index.php (script.js) → POST JSON → process_payment.php
        ↓
OAuth token (Daraja) → STK Push request → Prompt sent to user's phone
        ↓
User enters M-Pesa PIN → payment completes
        ↓
Daraja → callback.php → logs result → responds to M-Pesa
```

## ⚠️ Security Notes

- **Do not commit real credentials to a public repository.** Move `CONSUMER_KEY`, `CONSUMER_SECRET`, and `PASSKEY` into environment variables or a git-ignored config file.
- `CALLBACK_URL` must be HTTPS and publicly reachable for M-Pesa to deliver async results.
- Callback/transaction log files may contain payment data — keep them out of version control.

## License

This project is provided as-is for educational and demonstration purposes.
