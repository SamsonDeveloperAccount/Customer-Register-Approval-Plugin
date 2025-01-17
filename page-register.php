<?php
/* Template Name: Custom Registration Page */

get_header(); ?>

<style>
    #welcome-section {
        background-color: #fff;
        padding: 20px;
        border:2px solid;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #welcome-section h3 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
    }

    #welcome-section p {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    #welcome-section a.woocommerce-Button {
        background-color: #000;
        color: #fff;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
        border:1px solid;
    }

    #welcome-section a.woocommerce-Button:hover {
        background-color: #fff;
        text-decoration: none;
        color: #000;
        border:1px solid;
    }

    .acknowledge-checkbox {
        margin-top: 20px;
        text-align: left;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
    }

    .acknowledge-checkbox input[type="checkbox"] {
        margin-right: 10px;
    }

    .form-section {
        display: none;
    }
    .form-section.active {
        display: block;
    }
    .error-message {
        color: red;
        margin-top: 5px;
        font-size: 0.875em;
    }

    #next-button[disabled] {
        background-color: #ccc;
        cursor: not-allowed;
    }
</style>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="woocommerce">

            <?php wc_print_notices(); ?>

            <h2><?php _e('Vendor Register', 'woocommerce'); ?></h2>

            <form id="registration-form" method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?> >

                <!-- Welcome Message Section -->
                <div class="form-section" id="welcome-section">
                    <h3><?php _e('Welcome to Maxifore Beta - Online Dental Grafting Solutions', 'woocommerce'); ?></h3>
                    <p><?php _e('Before proceeding with your registration, please note that <b style="color:red;">this website currently only supports upfront payments via Stripe</b> using a credit card. If you do wish to set up a<b> credit facility and payment terms with Samson Medical, please register for an account on our current B2B portal below</b>:', 'woocommerce'); ?></p>
                    <a href="https://smt.dearportal.com/" target="_blank" class="woocommerce-Button button">
                        <?php _e('Visit Samson B2B Portal', 'woocommerce'); ?>
                    </a>
                    <p><?php _e('Maxifore B2B is currently under development and will be available to the public soon.', 'woocommerce'); ?></p>

                    <!-- Acknowledge Section -->
                    <div class="acknowledge-checkbox">
                        <input type="checkbox" id="acknowledge_checkbox" name="acknowledge_checkbox">
                        <label for="acknowledge_checkbox"><?php _e('I\'ve acknowledged the situation and will proceed with intime payment account registration.', 'woocommerce'); ?></label>
                    </div>
                    <span class="error-message" id="checkbox_error"><?php _e('Please acknowledge the terms to proceed.', 'woocommerce'); ?></span>
                </div>


                <!-- Facility Contact Information Section -->
                <div class="form-section" id="facility-contact-section">
                    <h3><?php _e('Facility Contact Information', 'woocommerce'); ?></h3>
                    <?php do_action('woocommerce_register_form_start'); ?>

                    <div class="form-row form-row-wide" style="display: flex; justify-content: space-between; gap: 20px;">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="flex: 1;">
                            <label for="reg_first_name"><?php _e('First Name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="first_name" id="reg_first_name" autocomplete="given-name" value="<?php if (!empty($_POST['first_name'])) echo esc_attr(wp_unslash($_POST['first_name'])); ?>" />
                            <span class="error-message" id="error_reg_first_name"></span>
                        </p>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="flex: 1;">
                            <label for="reg_last_name"><?php _e('Last Name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="last_name" id="reg_last_name" autocomplete="family-name" value="<?php if (!empty($_POST['last_name'])) echo esc_attr(wp_unslash($_POST['last_name'])); ?>" />
                            <span class="error-message" id="error_reg_last_name"></span>
                        </p>
                    </div>

                    <div class="form-row form-row-wide">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_email"><?php _e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text required" name="email" id="reg_email" autocomplete="email" value="<?php if (!empty($_POST['email'])) echo esc_attr(wp_unslash($_POST['email'])); ?>" />
                            <span class="error-message" id="error_reg_email"></span>
                        </p>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_phone"><?php _e('Phone Number', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="phone" id="reg_phone" autocomplete="phone" value="<?php if (!empty($_POST['phone'])) echo esc_attr(wp_unslash($_POST['phone'])); ?>" />
                            <span class="error-message" id="error_reg_phone"></span>
                        </p>
                    </div>
                </div>



                <!-- Facility Address Section -->
                <div class="form-section" id="facility-address-section">
                    <h3><?php _e('Facility Address', 'woocommerce'); ?></h3>
                    <div class="form-row form-row-wide">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_clinic_name"><?php _e('Clinic Name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="clinic_name" id="reg_clinic_name" autocomplete="organization" value="<?php if (!empty($_POST['clinic_name'])) echo esc_attr(wp_unslash($_POST['clinic_name'])); ?>" />
                            <span class="error-message" id="error_reg_clinic_name"></span>
                        </p>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_abn_nzbn"><?php _e('ABN/NZBN Number', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="abn_nzbn" id="reg_abn_nzbn" autocomplete="off" value="<?php if (!empty($_POST['abn_nzbn'])) echo esc_attr(wp_unslash($_POST['abn_nzbn'])); ?>" />
                            <span class="error-message" id="error_reg_abn_nzbn"></span>
                        </p>
                    </div>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_address_1"><?php _e('Address Line 1', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="address_1" id="reg_address_1" autocomplete="address-line1" value="<?php if (!empty($_POST['address_1'])) echo esc_attr(wp_unslash($_POST['address_1'])); ?>" />
                        <span class="error-message" id="error_reg_address_1"></span>
                    </p>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_address_2"><?php _e('Address Line 2', 'woocommerce'); ?></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="address_2" id="reg_address_2" autocomplete="address-line2" value="<?php if (!empty($_POST['address_2'])) echo esc_attr(wp_unslash($_POST['address_2'])); ?>" />
                        <span class="error-message" id="error_reg_address_2"></span>
                    </p>

                    <div class="form-row form-row-wide" style="display: flex; justify-content: space-between;">
                        <div class="form-group" style="width: 30%;">
                            <label for="reg_city"><?php _e('City/Suburb', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="city" id="reg_city" autocomplete="address-level2" value="<?php if (!empty($_POST['city'])) echo esc_attr(wp_unslash($_POST['city'])); ?>" />
                            <span class="error-message" id="error_reg_city"></span>
                        </div>

                        <div class="form-group" style="width: 30%;">
                            <label for="reg_state"><?php _e('State/Region', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="state" id="reg_state" autocomplete="address-level1" value="<?php if (!empty($_POST['state'])) echo esc_attr(wp_unslash($_POST['state'])); ?>" />
                            <span class="error-message" id="error_reg_state"></span>
                        </div>

                        <div class="form-group" style="width: 30%;">
                            <label for="reg_country"><?php _e('Country', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <select name="country" id="reg_country" class="woocommerce-Input woocommerce-Input--select required">
                                <option value=""><?php _e('Select your country', 'woocommerce'); ?></option>
                                <option value="australia" <?php if (isset($_POST['country']) && $_POST['country'] == 'australia') echo 'selected="selected"'; ?>><?php _e('Australia', 'woocommerce'); ?></option>
                                <option value="new_zealand" <?php if (isset($_POST['country']) && $_POST['country'] == 'new_zealand') echo 'selected="selected"'; ?>><?php _e('New Zealand', 'woocommerce'); ?></option>
                            </select>
                            <span class="error-message" id="error_reg_country"></span>
                        </div>
                    </div>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_postcode"><?php _e('Postcode / ZIP', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="postcode" id="reg_postcode" autocomplete="postal-code" value="<?php if (!empty($_POST['postcode'])) echo esc_attr(wp_unslash($_POST['postcode'])); ?>" />
                        <span class="error-message" id="error_reg_postcode"></span>
                    </p>
                </div>

                <!-- Billing Address Section -->
                <div class="form-section" id="billing-address-section">
                    <h3><?php _e('Billing Address', 'woocommerce'); ?></h3>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label><b><?php _e('Use facility address for billing?', 'woocommerce'); ?>&nbsp;<span class="required">*</span></b></label>
                        <input type="radio" name="same_billing_address" value="yes" id="same_billing_address_yes" <?php checked('yes', !empty($_POST['same_billing_address']) ? $_POST['same_billing_address'] : ''); ?>/> <label for="same_billing_address_yes"><?php _e('Yes', 'woocommerce'); ?></label>
                        <input type="radio" name="same_billing_address" value="no" id="same_billing_address_no" <?php checked('no', !empty($_POST['same_billing_address']) ? $_POST['same_billing_address'] : ''); ?>/> <label for="same_billing_address_no"><?php _e('No', 'woocommerce'); ?></label>
                    </p>

                    <div id="billing_address_fields">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="billing_address_1"><?php _e('Address Line 1', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="billing_address_1" id="billing_address_1" autocomplete="billing address-line1" value="<?php if (!empty($_POST['billing_address_1'])) echo esc_attr(wp_unslash($_POST['billing_address_1'])); ?>" />
                            <span class="error-message" id="error_billing_address_1"></span>
                        </p>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="billing_address_2"><?php _e('Address Line 2', 'woocommerce'); ?></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_2" id="billing_address_2" autocomplete="billing address-line2" value="<?php if (!empty($_POST['billing_address_2'])) echo esc_attr(wp_unslash($_POST['billing_address_2'])); ?>" />
                            <span class="error-message" id="error_billing_address_2"></span>
                        </p>

                        <div class="form-row form-row-wide" style="display: flex; justify-content: space-between;">
                            <div class="form-group" style="width: 30%;">
                                <label for="billing_city"><?php _e('City', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="billing_city" id="billing_city" autocomplete="billing address-level2" value="<?php if (!empty($_POST['billing_city'])) echo esc_attr(wp_unslash($_POST['billing_city'])); ?>" />
                                <span class="error-message" id="error_billing_city"></span>
                            </div>

                            <div class="form-group" style="width: 30%;">
                                <label for="billing_state"><?php _e('State/Region', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="billing_state" id="billing_state" autocomplete="billing address-level1" value="<?php if (!empty($_POST['billing_state'])) echo esc_attr(wp_unslash($_POST['billing_state'])); ?>" />
                                <span class="error-message" id="error_billing_state"></span>
                            </div>

                            <div class="form-group" style="width: 30%;">
                                <label for="billing_country"><?php _e('Country', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <select name="billing_country" id="billing_country" class="woocommerce-Input woocommerce-Input--select required">
                                    <option value=""><?php _e('Select your country', 'woocommerce'); ?></option>
                                    <option value="australia" <?php if (isset($_POST['billing_country']) && $_POST['billing_country'] == 'australia') echo 'selected="selected"'; ?>><?php _e('Australia', 'woocommerce'); ?></option>
                                    <option value="new_zealand" <?php if (isset($_POST['billing_country']) && $_POST['billing_country'] == 'new_zealand') echo 'selected="selected"'; ?>><?php _e('New Zealand', 'woocommerce'); ?></option>
                                </select>
                                <span class="error-message" id="error_billing_country"></span>
                            </div>
                        </div>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="billing_postcode"><?php _e('Postcode / ZIP', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="billing_postcode" id="billing_postcode" autocomplete="billing postal-code" value="<?php if (!empty($_POST['billing_postcode'])) echo esc_attr(wp_unslash($_POST['billing_postcode'])); ?>" />
                            <span class="error-message" id="error_billing_postcode"></span>
                        </p>
                    </div>
                </div>

                <!-- Delivery Address Section -->
                <div class="form-section" id="delivery-address-section">
                    <h3><?php _e('Delivery Address', 'woocommerce'); ?></h3>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label><b><?php _e('Use facility address for delivery?', 'woocommerce'); ?>&nbsp;<span class="required">*</span></b></label>
                        <input type="radio" name="same_delivery_address" value="yes" id="same_delivery_address_yes" <?php checked('yes', !empty($_POST['same_delivery_address']) ? $_POST['same_delivery_address'] : ''); ?>/> <label for="same_delivery_address_yes"><?php _e('Yes', 'woocommerce'); ?></label>
                        <input type="radio" name="same_delivery_address" value="no" id="same_delivery_address_no" <?php checked('no', !empty($_POST['same_delivery_address']) ? $_POST['same_delivery_address'] : ''); ?>/> <label for="same_delivery_address_no"><?php _e('No', 'woocommerce'); ?></label>
                    </p>

                    <div id="delivery_address_fields">
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="delivery_address_1"><?php _e('Address Line 1', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="delivery_address_1" id="delivery_address_1" autocomplete="shipping address-line1" value="<?php if (!empty($_POST['delivery_address_1'])) echo esc_attr(wp_unslash($_POST['delivery_address_1'])); ?>" />
                            <span class="error-message" id="error_delivery_address_1"></span>
                        </p>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="delivery_address_2"><?php _e('Address Line 2', 'woocommerce'); ?></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="delivery_address_2" id="delivery_address_2" autocomplete="shipping address-line2" value="<?php if (!empty($_POST['delivery_address_2'])) echo esc_attr(wp_unslash($_POST['delivery_address_2'])); ?>" />
                            <span class="error-message" id="error_delivery_address_2"></span>
                        </p>

                        <div class="form-row form-row-wide" style="display: flex; justify-content: space-between;">
                            <div class="form-group" style="width: 30%;">
                                <label for="delivery_city"><?php _e('City', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="delivery_city" id="delivery_city" autocomplete="shipping address-level2" value="<?php if (!empty($_POST['delivery_city'])) echo esc_attr(wp_unslash($_POST['delivery_city'])); ?>" />
                                <span class="error-message" id="error_delivery_city"></span>
                            </div>

                            <div class="form-group" style="width: 30%;">
                                <label for="delivery_state"><?php _e('State/Region', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="delivery_state" id="delivery_state" autocomplete="shipping address-level1" value="<?php if (!empty($_POST['delivery_state'])) echo esc_attr(wp_unslash($_POST['delivery_state'])); ?>" />
                                <span class="error-message" id="error_delivery_state"></span>
                            </div>

                            <div class="form-group" style="width: 30%;">
                                <label for="delivery_country"><?php _e('Country', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <select name="delivery_country" id="delivery_country" class="woocommerce-Input woocommerce-Input--select required">
                                    <option value=""><?php _e('Select your country', 'woocommerce'); ?></option>
                                    <option value="australia" <?php if (isset($_POST['delivery_country']) && $_POST['delivery_country'] == 'australia') echo 'selected="selected"'; ?>><?php _e('Australia', 'woocommerce'); ?></option>
                                    <option value="new_zealand" <?php if (isset($_POST['delivery_country']) && $_POST['delivery_country'] == 'new_zealand') echo 'selected="selected"'; ?>><?php _e('New Zealand', 'woocommerce'); ?></option>
                                </select>
                                <span class="error-message" id="error_delivery_country"></span>
                            </div>
                        </div>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="delivery_postcode"><?php _e('Postcode / ZIP', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text required" name="delivery_postcode" id="delivery_postcode" autocomplete="shipping postal-code" value="<?php if (!empty($_POST['delivery_postcode'])) echo esc_attr(wp_unslash($_POST['delivery_postcode'])); ?>" />
                            <span class="error-message" id="error_delivery_postcode"></span>
                        </p>
                    </div>
                </div>

                <div class="form-navigation" style="display: flex; justify-content: space-between; gap: 20px;">
                    <button type="button" id="back-button" class="woocommerce-Button button" style="display: none;"><?php esc_html_e('Back', 'woocommerce'); ?></button>
                    <button type="button" id="next-button" class="woocommerce-Button button"><?php esc_html_e('Next', 'woocommerce'); ?></button>
                    <button type="submit" id="register-button" class="woocommerce-Button button" style="display: none;" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                </div>

                <?php do_action('woocommerce_register_form'); ?>
                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                <?php do_action('woocommerce_register_form_end'); ?>

            </form>
        </div>
    </main>
</div>


<script>

document.addEventListener('DOMContentLoaded', function() {
    var nextButton = document.getElementById('next-button');
    var checkbox = document.getElementById('acknowledge_checkbox');
    var checkboxError = document.getElementById('checkbox_error');

    // Initially disable the Next button
    nextButton.disabled = true;

    // Enable the Next button only when the checkbox is checked
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            nextButton.disabled = false;
            checkboxError.style.display = 'none'; // Hide the error message
        } else {
            nextButton.disabled = true;
            checkboxError.style.display = 'block'; // Show the error message if unchecked
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var currentSection = 0;
    var sections = document.querySelectorAll('.form-section');
    var backButton = document.getElementById('back-button');
    var nextButton = document.getElementById('next-button');
    var registerButton = document.getElementById('register-button');

    function showSection(sectionIndex) {
        sections.forEach((section, index) => {
            section.classList.toggle('active', index === sectionIndex);
        });

        backButton.style.display = sectionIndex === 0 ? 'none' : 'inline-block';
        nextButton.style.display = sectionIndex === sections.length - 1 ? 'none' : 'inline-block';
        registerButton.style.display = sectionIndex === sections.length - 1 ? 'inline-block' : 'none';
    }

    function validateCurrentSection() {
        var valid = true;
        var inputs = sections[currentSection].querySelectorAll('.required');
        var namePattern = /^[a-zA-Z]+$/; // Only letters
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email pattern
        var phonePattern = /^(\+?\d{1,3})?(\(?\d{1,4}\)?)?(\d{1,4})?(\d{1,4})?(\d{1,9})$/;
        var abnNzbnPattern = /^\d{11,13}$/; // Only numbers, 11, max 13 characters

        inputs.forEach(function(input) {
            var errorElement = document.getElementById('error_' + input.id);
            var skipValidation = (currentSection === 2 && sameBillingAddressYes.checked) ||
                                 (currentSection === 3 && sameDeliveryAddressYes.checked);
            
            if (input && input.value === '' && !skipValidation) {
                if (errorElement) errorElement.textContent = 'This field is required.';
                input.style.border = '1px solid red';
                valid = false;
            } else if ((input.id === 'reg_first_name' || input.id === 'reg_last_name') && !namePattern.test(input.value)) {
                if (errorElement) errorElement.textContent = 'Only letters are allowed, no spaces or special characters.';
                input.style.border = '1px solid red';
                valid = false;
            } else if (input.id === 'reg_email' && !emailPattern.test(input.value)) {
                if (errorElement) errorElement.textContent = 'Please enter a valid email address.';
                input.style.border = '1px solid red';
                valid = false;
            } else if (input.id === 'reg_phone' && !phonePattern.test(input.value)) {
                if (errorElement) errorElement.textContent = 'Please enter a valid phone number.';
                input.style.border = '1px solid red';
                valid = false;
            } else if (input.id === 'reg_abn_nzbn' && !abnNzbnPattern.test(input.value)) {
                if (errorElement) errorElement.textContent = 'Please enter a valid ABN/NZBN (up to 13 digits).';
                input.style.border = '1px solid red';
                valid = false;
            } else {
                if (errorElement) errorElement.textContent = '';
                input.style.border = '';
            }
        });

        return valid;
    }

    nextButton.addEventListener('click', function() {
        if (validateCurrentSection()) {
            currentSection++;
            showSection(currentSection);
        }
    });

    backButton.addEventListener('click', function() {
        currentSection--;
        showSection(currentSection);
    });

    registerButton.addEventListener('click', function(event) {
        if (!validateCurrentSection()) {
            event.preventDefault();
        }
    });

    // Initialize
    showSection(currentSection);

    // Address copy logic
    var sameBillingAddressYes = document.getElementById('same_billing_address_yes');
    var sameBillingAddressNo = document.getElementById('same_billing_address_no');

    sameBillingAddressYes.addEventListener('change', function() {
        copyFacilityAddressToBilling();
    });

    sameBillingAddressNo.addEventListener('change', function() {
        clearBillingAddressFields();
    });

    var sameDeliveryAddressYes = document.getElementById('same_delivery_address_yes');
    var sameDeliveryAddressNo = document.getElementById('same_delivery_address_no');

    sameDeliveryAddressYes.addEventListener('change', function() {
        copyFacilityAddressToDelivery();
    });

    sameDeliveryAddressNo.addEventListener('change', function() {
        clearDeliveryAddressFields();
    });

    function copyFacilityAddressToBilling() {
        document.getElementById('billing_address_1').value = document.getElementById('reg_address_1').value;
        document.getElementById('billing_address_2').value = document.getElementById('reg_address_2').value;
        document.getElementById('billing_city').value = document.getElementById('reg_city').value;
        document.getElementById('billing_state').value = document.getElementById('reg_state').value;
        document.getElementById('billing_country').value = document.getElementById('reg_country').value;
        document.getElementById('billing_postcode').value = document.getElementById('reg_postcode').value;
    }

    function copyFacilityAddressToDelivery() {
        document.getElementById('delivery_address_1').value = document.getElementById('reg_address_1').value;
        document.getElementById('delivery_address_2').value = document.getElementById('reg_address_2').value;
        document.getElementById('delivery_city').value = document.getElementById('reg_city').value;
        document.getElementById('delivery_state').value = document.getElementById('reg_state').value;
        document.getElementById('delivery_country').value = document.getElementById('reg_country').value;
        document.getElementById('delivery_postcode').value = document.getElementById('reg_postcode').value;
    }

    function clearBillingAddressFields() {
        document.getElementById('billing_address_1').value = '';
        document.getElementById('billing_address_2').value = '';
        document.getElementById('billing_city').value = '';
        document.getElementById('billing_state').value = '';
        document.getElementById('billing_country').value = '';
        document.getElementById('billing_postcode').value = '';
    }

    function clearDeliveryAddressFields() {
        document.getElementById('delivery_address_1').value = '';
        document.getElementById('delivery_address_2').value = '';
        document.getElementById('delivery_city').value = '';
        document.getElementById('delivery_state').value = '';
        document.getElementById('delivery_country').value = '';
        document.getElementById('delivery_postcode').value = '';
    }
});
</script>


<?php get_footer(); ?>

