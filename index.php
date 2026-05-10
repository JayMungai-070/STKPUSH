<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Packages - M-Pesa Payment Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <div class="spinner">
            <i class="fas fa-circle-notch fa-spin"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <header class="animate__animated animate__fadeInDown">
            <h1><i class="fas fa-crown"></i> Premium Subscription Packages</h1>
        </header>

        <main class="animate__animated animate__fadeIn">
            <div class="packages-container">
                <!-- Basic Package -->
                <div class="package-card" data-amount="1000">
                    <div class="package-header">
                        <i class="fas fa-paper-plane fa-bounce"></i>
                        <h3>Basic</h3>
                        <div class="price">KES 1,000</div>
                        <div class="duration">Monthly</div>
                    </div>
                    <ul class="features">
                        <li><i class="fas fa-check"></i> Feature 1</li>
                        <li><i class="fas fa-check"></i> Feature 2</li>
                        <li><i class="fas fa-check"></i> Feature 3</li>
                    </ul>
                    <button class="select-package">Choose Basic</button>
                </div>

                <!-- Premium Package -->
                <div class="package-card featured" data-amount="2500">
                    <div class="package-header">
                        <i class="fas fa-star fa-bounce"></i>
                        <h3>Premium</h3>
                        <div class="price">KES 2,500</div>
                        <div class="duration">Monthly</div>
                    </div>
                    <ul class="features">
                        <li><i class="fas fa-check"></i> All Basic Features</li>
                        <li><i class="fas fa-check"></i> Premium Feature 1</li>
                        <li><i class="fas fa-check"></i> Premium Feature 2</li>
                        <li><i class="fas fa-check"></i> Premium Feature 3</li>
                    </ul>
                    <button class="select-package">Choose Premium</button>
                </div>

                <!-- Enterprise Package -->
                <div class="package-card" data-amount="5000">
                    <div class="package-header">
                        <i class="fas fa-building fa-bounce"></i>
                        <h3>James Kinyungu</h3>
                        <div class="price">KES 5,000</div>
                        <div class="duration">Monthly</div>
                    </div>
                    <ul class="features">
                        <li><i class="fas fa-check"></i> All Premium Features</li>
                        <li><i class="fas fa-check"></i> Enterprise Feature 1</li>
                        <li><i class="fas fa-check"></i> Enterprise Feature 2</li>
                        <li><i class="fas fa-check"></i> Enterprise Feature 3</li>
                    </ul>
                    <button class="select-package">Choose Enterprise</button>
                </div>
            </div>

            <!-- Payment Form (Initially Hidden) -->
            <div class="payment-card" id="paymentSection" style="display: none;">
                <div class="card-header">
                    <i class="fas fa-credit-card fa-bounce"></i>
                    <h2>Complete Subscription</h2>
                    <p id="selectedPackage" class="selected-package-text"></p>
                </div>

                <form id="paymentForm" class="payment-form">
                    <div class="form-group">
                        <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="254XXXXXXXXX" required>
                    </div>

                    <input type="hidden" id="amount" name="amount">
                    <input type="hidden" id="package_name" name="package_name">

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Subscribe Now
                        <span class="btn-loader"><i class="fas fa-circle-notch fa-spin"></i></span>
                    </button>
                </form>
            </div>
        </main>
    </div>

    <!-- Modal for payment status -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-info-circle"></i> Payment Status</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div id="statusMessage"></div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>