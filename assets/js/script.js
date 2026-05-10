document.addEventListener('DOMContentLoaded', function() {
    const packageButtons = document.querySelectorAll('.select-package');
    const paymentSection = document.getElementById('paymentSection');
    const selectedPackageText = document.getElementById('selectedPackage');
    const amountInput = document.getElementById('amount');
    const packageNameInput = document.getElementById('package_name');
    const paymentForm = document.getElementById('paymentForm');
    const statusModal = document.getElementById('statusModal');
    const closeBtn = document.querySelector('.close');
    const statusMessage = document.getElementById('statusMessage');

    // Package selection
    packageButtons.forEach(button => {
        button.addEventListener('click', function() {
            const packageCard = this.closest('.package-card');
            const amount = packageCard.dataset.amount;
            const packageName = packageCard.querySelector('h3').textContent;
            
            amountInput.value = amount;
            packageNameInput.value = packageName;
            selectedPackageText.textContent = `Selected: ${packageName} - KES ${amount}`;
            
            paymentSection.style.display = 'block';
            paymentSection.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Form submission
    paymentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        
        submitBtn.disabled = true;
        btnLoader.style.display = 'inline-block';

        try {
            const response = await fetch('process_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    phone: document.getElementById('phone').value,
                    amount: document.getElementById('amount').value,
                    package: document.getElementById('package_name').value
                })
            });

            const result = await response.json();
            
            statusMessage.innerHTML = `
                <div class="status-message ${result.success ? 'success' : 'error'}">
                    <i class="fas ${result.success ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                    <p>${result.message}</p>
                </div>
            `;
            
            statusModal.style.display = 'block';
            
            if (result.success) {
                paymentForm.reset();
                paymentSection.style.display = 'none';
            }
        } catch (error) {
            statusMessage.innerHTML = `
                <div class="status-message error">
                    <i class="fas fa-times-circle"></i>
                    <p>Payment processing failed. Please try again.</p>
                </div>
            `;
            statusModal.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            btnLoader.style.display = 'none';
        }
    });

    // Close modal
    closeBtn.onclick = function() {
        statusModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == statusModal) {
            statusModal.style.display = 'none';
        }
    }
});