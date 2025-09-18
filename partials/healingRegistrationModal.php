<?php

// Determine current file directory
$dir = __DIR__;

// Load JSON files with absolute paths
$zonesData = json_decode(file_get_contents($dir . '/../data/zones.json'), true);
$countriesData = json_decode(file_get_contents($dir . '/../data/countries.json'), true);
$statesData = json_decode(file_get_contents($dir . '/../data/states.json'), true);

// Data extractor function
function extractTableData($jsonArray, $tableName)
{
    if (is_array($jsonArray)) {
        foreach ($jsonArray as $item) {
            if (
                isset($item['type'], $item['name'], $item['data']) &&
                $item['type'] === 'table' &&
                $item['name'] === $tableName
            ) {
                return $item['data'];
            }
        }
    }
    return null;
}

// Extract data
$zones = extractTableData($zonesData, 'zones') ?: [];
$countries = extractTableData($countriesData, 'countries') ?: [];
$states = extractTableData($statesData, 'states') ?: [];


?>

<!-- {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#healingRegistrationModal">
  Launch demo modal
</button> --}} -->

<div class="modal fade" id="healingRegistrationModal" tabindex="-1" aria-labelledby="healingRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content healing-modal">
            <!-- Header with Healing Theme -->
            <div class="modal-header healing-header">
                <h5 class="modal-title" id="healingRegistrationModalLabel">
                    <i class="fas fa-hands-praying me-2"></i>Join Healing Streams
                </h5>
                <button type="button" class="btn-close healing-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs healing-tabs mb-4" id="registrationTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-tab-pane" type="button">
                            <i class="fas fa-envelope me-2"></i>Email Registration
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone-tab-pane" type="button">
                            <i class="fas fa-phone-alt me-2"></i>Phone Registration
                        </button>
                    </li>
                </ul>

                <!-- Form Content -->
                <form id="healingRegistrationForm" action="register.php" method="POST">

                    <!-- Progress Bar -->
                    <div class="healing-progress mb-4">
                        <div class="healing-progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="registrationTabContent">
                        <!-- Email Tab -->
                        <div class="tab-pane fade show active" id="email-tab-pane" role="tabpanel">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email"  autocapitalize="off" spellcheck="false" autocomplete="email" class="form-control healing-input" id="email" name="email" placeholder="your@email.com">
                                <div class="invalid-feedback" id="email-error"></div>
                            </div>
                        </div>

                        <!-- Phone Tab -->
                        <!-- Intl Tel Input CSS -->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
                        <!-- Intl Tel Input JS -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

                        <div class="tab-pane fade" id="phone-tab-pane" role="tabpanel">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control healing-input w-100" id="phone" name="phone">
                                <input type="hidden" id="country_code" name="country_code">
                                <div class="invalid-feedback" id="phone-error"></div>
                            </div>
                        </div>

                        <!-- Optional CSS fix in case intl-tel-input overrides width -->
                        <style>
                            .iti {
                                width: 100%;
                            }
                        </style>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const phoneInput = document.querySelector("#phone");
                                const countryCodeInput = document.querySelector("#country_code");

                                const iti = window.intlTelInput(phoneInput, {
                                    preferredCountries: ['ng', 'us', 'gb'],
                                    initialCountry: "ng",
                                    separateDialCode: true,
                                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
                                });

                                phoneInput.addEventListener("input", function() {
                                    this.value = this.value.replace(/\D/g, '');
                                });

                                phoneInput.addEventListener("countrychange", function() {
                                    countryCodeInput.value = iti.getSelectedCountryData().dialCode;
                                });

                                // Initialize hidden field
                                countryCodeInput.value = iti.getSelectedCountryData().dialCode;
                            });
                        </script>

                    </div>

                    <!-- Common Fields -->
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control healing-input" id="fullname" name="fullname" placeholder="Your full name" required>
                    </div>

                    <div class="mb-3" id="zone_field_wrapper">
                        <label for="zone_id" class="form-label">Zone </label>
                        <select class="form-select healing-input" id="zone_id" name="zone_id" required style="display:inline;">
                            <option value="28892">Not Applicable</option>
                            <?php foreach ($zones as $zone): ?>
                                <option value="<?= $zone['zone_id'] ?>"><?= $zone['zone_name'] ?></option>
                            <?php endforeach; ?>

                        </select>
                        <div id="zone_auto_msg" class="form-text" style="display:none;margin-top:6px;color:#198754;">Zone set automatically from your link.</div>
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label"> Age : 1 - 12 years </label>
                        <input type="number" class="form-control healing-input" id="age" name="age" min="1" max="12" required>
                    </div>
                    <script>
                        document.getElementById('age').addEventListener('input', function() {
                            let value = parseInt(this.value);
                            if (value > 12) this.value = 12;
                            if (value < 1) this.value = 1;
                        });
                    </script>

                    <!-- Location Fields -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="country_id" class="form-label">Country</label>
                            <select class="form-select healing-input" id="country_id" name="country_id" required>
                                <option value="" disabled selected>Select country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?= $country['country_id'] ?>"><?= $country['country_name'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="state_id" class="form-label">State</label>
                            <select class="form-select healing-input" id="state_id" name="state_id" disabled required>
                                <option value="" disabled selected>Select state</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control healing-input" id="city" name="city" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" name="submit" class="btn healing-submit-btn">
                            <i class="fas fa-user-plus me-2"></i>Complete Registration
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    .healing-modal {
        border-radius: 15px;
        overflow: hidden;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 100, 150, 0.2);
    }

    .healing-header {
        background: linear-gradient(135deg, #4a89dc, #3bafda);
        color: white;
        border-bottom: none;
        padding: 1.2rem;
    }

    .healing-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .healing-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        padding: 0.8rem 1.2rem;
    }

    .healing-tabs .nav-link.active {
        color: #4a89dc;
        background: transparent;
        border-bottom: 3px solid #4a89dc;
    }

    .healing-progress {
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
    }

    .healing-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4a89dc, #3bafda);
        transition: width 0.4s ease;
    }

    .healing-input {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }

    .healing-input:focus {
        border-color: #4a89dc;
        box-shadow: 0 0 0 0.2rem rgba(74, 137, 220, 0.25);
    }

    .healing-country-code {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .healing-submit-btn {
        background: linear-gradient(135deg, #4a89dc, #3bafda);
        color: white;
        border: none;
        padding: 0.8rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .healing-submit-btn:hover {
        background: linear-gradient(135deg, #3b7bc8, #2a9ac8);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('healingRegistrationForm');
        const emailTab = document.getElementById('email-tab');
        const phoneTab = document.getElementById('phone-tab');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const countrySelect = document.getElementById('country_id');
        const stateSelect = document.getElementById('state_id');

        // Initialize TomSelect
        const zoneTS = new TomSelect('#zone_id', {
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            maxOptions: null, // Remove limit on displayed options
        });

        // Zone ref handling from URL
        try {
            const url = new URL(window.location.href);
            const ref = url.searchParams.get('ref') || (url.pathname.includes('/kids/ref/') ? url.pathname.split('/kids/ref/')[1] : null);
            if (ref) {
                // Fetch zones mapping by ref from embedded JSON (loaded server-side into page as zones array via PHP)
                // Build a quick lookup map from existing <option> text by matching data from zones.json via AJAX
                fetch('data/zones.json')
                    .then(r => r.json())
                    .then(json => {
                        const items = Array.isArray(json) ? json : [];
                        let zonesData = [];
                        if (items.length) {
                            const table = items.find(i => i && i.type === 'table' && i.name === 'zones');
                            zonesData = (table && table.data) ? table.data : [];
                        }
                        const matched = zonesData.find(z => (z.ref || '').toLowerCase() === ref.toLowerCase());
                        if (matched && matched.zone_id) {
                            zoneTS.setValue(String(matched.zone_id), true);
                            const wrapper = document.getElementById('zone_field_wrapper');
                            const helper = document.getElementById('zone_auto_msg');
                            if (wrapper) {
                                wrapper.style.display = 'none';
                            }
                            if (helper) {
                                helper.style.display = 'block';
                            }
                        }
                    })
                    .catch(() => {});
            }
        } catch(e) {}

        const countryTS = new TomSelect('#country_id', {
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            maxOptions: null, // Remove limit on displayed options
        });

        const stateTS = new TomSelect('#state_id', {
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            maxOptions: null, // Remove limit on displayed options
        });

        // Load states dynamically (with TomSelect)
        countrySelect.addEventListener('change', function() {
            const countryId = this.value;

            stateTS.clearOptions();
            stateTS.disable();
            stateTS.addOption({
                value: '',
                text: 'Loading states...'
            });
            stateTS.refreshOptions();

            if (!countryId) return;

            fetch(`api/states.php?country_id=${countryId}`)
                .then(response => response.json())
                .then(data => {
                    stateTS.clearOptions();
                    if (Array.isArray(data) && data.length > 0) {
                        stateTS.addOption({
                            value: '',
                            text: 'Select a state'
                        });
                        data.forEach(state => {
                            stateTS.addOption({
                                value: state.state_id,
                                text: state.state_name
                            });
                        });
                        stateTS.enable();
                        stateTS.refreshOptions();
                    } else {
                        stateTS.addOption({
                            value: '',
                            text: 'No states found'
                        });
                        stateTS.refreshOptions();
                    }
                    updateProgress();
                })
                .catch(error => {
                    console.error('Error loading states:', error);
                    stateTS.clearOptions();
                    stateTS.addOption({
                        value: '',
                        text: 'Failed to load states'
                    });
                    stateTS.refreshOptions();
                });
        });

        emailTab.addEventListener('click', () => {
            phoneInput.value = '';
            phoneInput.classList.remove('is-invalid');
            document.getElementById('phone-error').textContent = '';
            updateProgress();
        });

        phoneTab.addEventListener('click', () => {
            emailInput.value = '';
            emailInput.classList.remove('is-invalid');
            document.getElementById('email-error').textContent = '';
            updateProgress();
        });

        function updateProgress() {
            const inputs = form.querySelectorAll('input, select');
            let filled = 0;
            inputs.forEach(input => {
                if (input.value && !input.disabled) filled++;
            });
            const progress = (filled / inputs.length) * 100;
            document.querySelector('.healing-progress-bar').style.width = `${progress}%`;
        }

        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', updateProgress);
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            const emailTabActive = emailTab.classList.contains('active');
            let hasErrors = false;

            if (emailTabActive && !emailInput.value) {
                emailInput.classList.add('is-invalid');
                document.getElementById('email-error').textContent = 'Please enter your email address';
                hasErrors = true;
            }

            if (!emailTabActive && !phoneInput.value) {
                phoneInput.classList.add('is-invalid');
                document.getElementById('phone-error').textContent = 'Please enter your phone number';
                hasErrors = true;
            }

            function validatePhoneNumber(phone, countryCode) {
                const phoneRegex = /^\d{8,15}$/;
                return phoneRegex.test(phone) ? null : "Invalid phone number format";
            }

            if (!emailTabActive) {
                const countryCode = document.getElementById('country_code').value;
                const phone = phoneInput.value.trim();
                const phoneError = validatePhoneNumber(phone, countryCode);

                if (phoneError) {
                    phoneInput.classList.add('is-invalid');
                    document.getElementById('phone-error').textContent = phoneError;
                    hasErrors = true;
                }
            }

            if (hasErrors) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(form);
                const response = await fetch('register.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const rawText = await response.text();
                let result;

                try {
                    result = JSON.parse(rawText);
                } catch (jsonError) {
                    console.error('JSON parse error:', jsonError);
                    throw new Error("Invalid response from server");
                }

                if (response.ok && result.registration_id) {
                    const regId = result.registration_id;
                    const isEmail = emailTabActive;

                    // Show download link with click handler
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Completed!',
                        html: `
                    Thank you for registering.<br>
                    <a href="#" id="download-link">
                        📘 Download Your Free Magazine for Kids Here
                    </a>`,
                        confirmButtonText: 'Close'
                    }).then(() => {
                        form.reset();
                    });
                    // Attach click event after modal renders
                    setTimeout(() => {
                        const downloadLink = document.getElementById('download-link');
                        if (downloadLink) {
                            downloadLink.addEventListener('click', function(e) {
                                e.preventDefault();

                                // Track download
                                fetch('track_download.php', {
                                    method: 'POST',
                                    body: JSON.stringify({
                                        id: regId,
                                        is_email: isEmail
                                    }),
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                }).catch(e => console.error('Tracking failed:', e));

                                // Trigger actual file download
                                const fileUrl = './assets/magazine/HTTN_Magazine_For_Kids_September_2025_FOR_PRINT.pdf';
                                const a = document.createElement('a');
                                a.href = fileUrl;
                                a.download = 'HTTN_Magazine_For_Kids_September_2025.pdf';
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                            });
                        }
                    }, 200);
                } else {
                    // Handle errors
                    if (result.message && result.message.errors) {
                        for (const [field, message] of Object.entries(result.message.errors)) {
                            const input = form.querySelector(`[name="${field}"]`) || form.querySelector(`#${field}`);
                            if (input) {
                                input.classList.add('is-invalid');
                                const errorElement = document.getElementById(`${field}-error`) || input.nextElementSibling;
                                if (errorElement) errorElement.textContent = message;
                            } else if (field === 'general') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: message
                                });
                            }
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: result?.message?.message || 'Please correct the errors and try again'
                    })
                }
            } catch (error) {
                console.error('Submission Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'An error occurred while processing your request'
                });
            } finally {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        });

        if (window.location.hash === '#healingRegistrationModal') {
            const modal = new bootstrap.Modal(document.getElementById('healingRegistrationModal'));
            modal.show();
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = ['email', 'fullname', 'phone', 'city'];
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.setAttribute('autocapitalize', id === 'fullname' || id === 'city' ? 'words' : 'off');
            el.setAttribute('spellcheck', 'false');
        }
    });
});
</script>

