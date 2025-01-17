<?php
/**
 * Plugin Name: Custom User Registration
 * Description: A plugin to handle custom user registration and notifications.
 * Version: 1.0
 * Author: Huaiqing Han
 * License: GPL2
 */

// Security check to prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Register the admin page for user approvals and settings
add_action('admin_menu', 'register_approval_and_settings_pages');
function register_approval_and_settings_pages() {
    add_users_page(
        'User Approvals',           // Page title
        'User Approvals',           // Menu title
        'manage_options',           // Capability
        'user-approvals',           // Menu slug
        'user_approvals_page'       // Function to display page content
    );

    add_options_page(
        'Email Settings',           // Page title
        'Email Settings',           // Menu title
        'manage_options',           // Capability
        'custom-user-email-settings', // Menu slug
        'email_settings_page'       // Function to display email settings
    );
}

// Register settings for email content
add_action('admin_init', 'register_email_settings');
function register_email_settings() {
    register_setting('custom_user_registration_settings', 'pending_approval_email_subject');
    register_setting('custom_user_registration_settings', 'pending_approval_email_body');
    register_setting('custom_user_registration_settings', 'approval_email_subject');
    register_setting('custom_user_registration_settings', 'approval_email_body');
    register_setting('custom_user_registration_settings', 'rejection_email_subject');
    register_setting('custom_user_registration_settings', 'rejection_email_body');

    // Register settings for admin notification email
    register_setting('custom_user_registration_settings', 'admin_pending_approval_email_subject');
    register_setting('custom_user_registration_settings', 'admin_pending_approval_email_body');

    // Register settings for admin approval notification email
    register_setting('custom_user_registration_settings', 'admin_approval_notification_email_subject');
    register_setting('custom_user_registration_settings', 'admin_approval_notification_email_body');
}


// Display the user approvals page
function user_approvals_page() {
    $args = array(
        'meta_key' => 'is_approved',
        'meta_value' => 0,
        'meta_compare' => '='
    );
    $unapproved_users = get_users($args);

    echo '<div class="wrap">';
    echo '<h1>' . __('User Approvals', 'textdomain') . '</h1>';

    if (!empty($unapproved_users)) {
        echo '<table class="wp-list-table widefat fixed striped users">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col" class="manage-column column-username">' . __('Username', 'textdomain') . '</th>';
        echo '<th scope="col" class="manage-column column-email">' . __('Email', 'textdomain') . '</th>';
        echo '<th scope="col" class="manage-column column-clinic-name">' . __('Clinic Name', 'textdomain') . '</th>';
        echo '<th scope="col" class="manage-column column-abn">' . __('ABN/NZBN', 'textdomain') . '</th>';
        echo '<th scope="col" class="manage-column column-address">' . __('Address', 'textdomain') . '</th>';
        echo '<th scope="col" class="manage-column column-registration-date">' . __('Registered Date', 'textdomain') . '</th>';
        echo '<th scope="col" class="manage-column column-actions">' . __('Actions', 'textdomain') . '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($unapproved_users as $user) {
            $clinic_name = get_user_meta($user->ID, 'clinic_name', true);
            $abn_nzbn = get_user_meta($user->ID, 'abn_nzbn', true);

            // Retrieve billing address
            $billing_address_1 = get_user_meta($user->ID, 'billing_address_1', true);
            $billing_address_2 = get_user_meta($user->ID, 'billing_address_2', true);
            $billing_city = get_user_meta($user->ID, 'billing_city', true);
            $billing_state = get_user_meta($user->ID, 'billing_state', true);
            $billing_postcode = get_user_meta($user->ID, 'billing_postcode', true);
            $billing_country = get_user_meta($user->ID, 'billing_country', true);

            // Concatenate billing address
            $billing_address = esc_html($billing_address_1) . ' ' . esc_html($billing_address_2) . ', ' . esc_html($billing_city) . ', ' . esc_html($billing_state) . ', ' . esc_html($billing_country) . ' ' . esc_html($billing_postcode);

            echo '<tr>';
            echo '<td class="username column-username">' . esc_html($user->user_login) . '</td>';
            echo '<td class="email column-email"><a href="mailto:' . esc_attr($user->user_email) . '">' . esc_html($user->user_email) . '</a></td>';
            echo '<td class="clinic-name column-clinic-name"><div>' . esc_html($clinic_name) . '</div></td>';
            echo '<td class="abn column-abn"><div>' . esc_html($abn_nzbn) . '</div></td>';
            echo '<td class="address column-address"><div>' . $billing_address . '</div></td>';
            echo '<td class="registration-date column-registration-date">' . date('Y/m/d', strtotime($user->user_registered)) . '</td>';
            echo '<td class="actions column-actions">';
            echo '<form method="post" action="' . admin_url('admin-post.php') . '" style="display:inline;">';
            echo wp_nonce_field('approve_reject_user_nonce_' . $user->ID, '_wpnonce', true, false);
            echo '<input type="hidden" name="action" value="approve_user">';
            echo '<input type="hidden" name="user_id" value="' . esc_attr($user->ID) . '">';
            echo '<input type="submit" class="button button-primary" value="' . __('Approve', 'textdomain') . '">';
            echo '</form>';
            echo ' ';
            echo '<form method="post" action="' . admin_url('admin-post.php') . '" style="display:inline;">';
            echo wp_nonce_field('approve_reject_user_nonce_' . $user->ID, '_wpnonce', true, false);
            echo '<input type="hidden" name="action" value="reject_user">';
            echo '<input type="hidden" name="user_id" value="' . esc_attr($user->ID) . '">';
            echo '<input type="submit" class="button button-secondary" value="' . __('Reject', 'textdomain') . '">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>' . __('No users pending approval.', 'textdomain') . '</p>';
    }

    echo '</div>';
}

// Display the email settings page
// Display the email settings page
function email_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Custom User Registration Email Settings', 'textdomain'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('custom_user_registration_settings');
            do_settings_sections('custom_user_registration_settings');
            ?>
            
            <!-- User Emails -->
            <h2><?php _e('Pending Approval Email', 'textdomain'); ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Subject', 'textdomain'); ?></th>
                    <td><input type="text" name="pending_approval_email_subject" value="<?php echo esc_attr(get_option('pending_approval_email_subject', 'Your account is pending approval')); ?>" class="regular-text"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Body', 'textdomain'); ?></th>
                    <td><textarea name="pending_approval_email_body" class="large-text" rows="10"><?php echo esc_textarea(get_option('pending_approval_email_body', 'Hello {username},<br><br>Your account is pending approval.')); ?></textarea></td>
                </tr>
            </table>

            <!-- Admin Emails -->
            <h2><?php _e('Admin Pending Approval Notification Email', 'textdomain'); ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Subject', 'textdomain'); ?></th>
                    <td><input type="text" name="admin_pending_approval_email_subject" value="<?php echo esc_attr(get_option('admin_pending_approval_email_subject', 'New User Registration Pending Approval')); ?>" class="regular-text"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Body', 'textdomain'); ?></th>
                    <td><textarea name="admin_pending_approval_email_body" class="large-text" rows="10"><?php echo esc_textarea(get_option('admin_pending_approval_email_body', 'A new user has registered and is pending approval.<br><br>Username: {username}<br>Email: {email}<br>Clinic Name: {clinic_name}<br>ABN/NZBN: {abn_nzbn}')); ?></textarea></td>
                </tr>
            </table>

            <h2><?php _e('Admin Approval Notification Email', 'textdomain'); ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Subject', 'textdomain'); ?></th>
                    <td><input type="text" name="admin_approval_notification_email_subject" value="<?php echo esc_attr(get_option('admin_approval_notification_email_subject', 'User Approved: {username}')); ?>" class="regular-text"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Body', 'textdomain'); ?></th>
                    <td><textarea name="admin_approval_notification_email_body" class="large-text" rows="10"><?php echo esc_textarea(get_option('admin_approval_notification_email_body', 'The following user has been approved:<br><br>Username: {username}<br>Email: {email}<br>Clinic Name: {clinic_name}<br>ABN/NZBN: {abn_nzbn}<br>Registered Date: {registered_date}<br>Billing Address: {billing_address}')); ?></textarea></td>
                </tr>
            </table>

            <h2><?php _e('Approval Email', 'textdomain'); ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Subject', 'textdomain'); ?></th>
                    <td><input type="text" name="approval_email_subject" value="<?php echo esc_attr(get_option('approval_email_subject', 'Your account has been approved')); ?>" class="regular-text"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Body', 'textdomain'); ?></th>
                    <td><textarea name="approval_email_body" class="large-text" rows="10"><?php echo esc_textarea(get_option('approval_email_body', 'Hello {username},<br><br>Your account has been approved. You can set a new password using the following link: <a href="{reset_url}">{reset_url}</a>')); ?></textarea></td>
                </tr>
            </table>

            <h2><?php _e('Rejection Email', 'textdomain'); ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Subject', 'textdomain'); ?></th>
                    <td><input type="text" name="rejection_email_subject" value="<?php echo esc_attr(get_option('rejection_email_subject', 'Your account has been rejected')); ?>" class="regular-text"></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Body', 'textdomain'); ?></th>
                    <td><textarea name="rejection_email_body" class="large-text" rows="10"><?php echo esc_textarea(get_option('rejection_email_body', 'Hello {username},<br><br>We regret to inform you that your account has been rejected. If you have any questions, please contact support.')); ?></textarea></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Handle approval submission and send approval email
add_action('admin_post_approve_user', 'approve_user');
function approve_user() {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'approve_reject_user_nonce_' . $_POST['user_id'])) {
        wp_die(__('Invalid request', 'textdomain'));
    }

    $user_id = intval($_POST['user_id']);
    $user = new WP_User($user_id);
    if ($user->exists()) {
        $user->set_role('customer');
        update_user_meta($user_id, 'is_approved', 1);
        if (isset($_POST['clinic_name'])) {
            update_user_meta($user_id, 'clinic_name', sanitize_text_field($_POST['clinic_name']));
        }
        if (isset($_POST['abn_nzbn'])) {
            update_user_meta($user_id, 'abn_nzbn', sanitize_text_field($_POST['abn_nzbn']));
        }

        // Generate password reset link
        $reset_key = get_password_reset_key($user);
        if (is_wp_error($reset_key)) {
            wp_die(__('Failed to generate password reset link', 'textdomain'));
        }
        $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');

        // Send approval email with HTML content
        $subject = get_option('approval_email_subject', 'Your account has been approved');
        $body = get_option('approval_email_body', 'Hello {username},<br><br>Your account has been approved. You can set a new password using the following link: <a href="{reset_url}">{reset_url}</a>');
        $body = str_replace('{username}', $user->user_login, $body);
        $body = str_replace('{reset_url}', $reset_url, $body);
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail($user->user_email, $subject, $body, $headers);

        // Send admin notification with user information
        $admin_email = 'customerservice@samsonmedtech.com,mateo.e@samsonmedtech.com';
        $admin_subject = get_option('admin_approval_notification_email_subject', 'User Approved: {username}');
        $admin_body = get_option('admin_approval_notification_email_body', 'The following user has been approved:<br><br>Username: {username}<br>Email: {email}<br>Clinic Name: {clinic_name}<br>ABN/NZBN: {abn_nzbn}<br>Registered Date: {registered_date}<br>Billing Address: {billing_address}');

        // Retrieve and format the billing address
        $billing_address_1 = get_user_meta($user_id, 'billing_address_1', true);
        $billing_address_2 = get_user_meta($user_id, 'billing_address_2', true);
        $billing_city = get_user_meta($user_id, 'billing_city', true);
        $billing_state = get_user_meta($user_id, 'billing_state', true);
        $billing_postcode = get_user_meta($user_id, 'billing_postcode', true);
        $billing_country = get_user_meta($user_id, 'billing_country', true);

        $billing_address = esc_html($billing_address_1) . ' ' . esc_html($billing_address_2) . ', ' . esc_html($billing_city) . ', ' . esc_html($billing_state) . ', ' . esc_html($billing_country) . ' ' . esc_html($billing_postcode);

        // Replace placeholders with actual values
        $admin_subject = str_replace('{username}', $user->user_login, $admin_subject);
        $admin_body = str_replace(
            array('{username}', '{email}', '{clinic_name}', '{abn_nzbn}', '{registered_date}', '{billing_address}'),
            array(
                $user->user_login, 
                $user->user_email, 
                get_user_meta($user_id, 'clinic_name', true) ?: 'N/A', 
                get_user_meta($user_id, 'abn_nzbn', true) ?: 'N/A', 
                date('Y/m/d', strtotime($user->user_registered)), 
                $billing_address
            ), 
            $admin_body
        );

        wp_mail($admin_email, $admin_subject, $admin_body, $headers);
    }

    wp_redirect(admin_url('users.php?page=user-approvals'));
    exit;
}
// Handle rejection submission and send rejection email
add_action('admin_post_reject_user', 'reject_user');
function reject_user() {
    // Verify nonce to ensure request validity
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'approve_reject_user_nonce_' . $_POST['user_id'])) {
        wp_die(__('Invalid request', 'textdomain'));
    }

    // Get the user ID from the POST request and fetch user data
    $user_id = intval($_POST['user_id']);
    $user = get_userdata($user_id);
    
    // Check if the current user has permission to delete users
    if (current_user_can('delete_users')) {
        // Attempt to delete the user from the database
        $deleted = wp_delete_user($user_id);
        if (!$deleted) {
            // Log an error and display a message if the user could not be deleted
            error_log(__('Failed to delete user with ID: ', 'textdomain') . $user_id);
            wp_die(__('Failed to delete user with ID: ', 'textdomain') . $user_id);
        }

        // Send rejection email with HTML content if user deletion is successful
        $subject = get_option('rejection_email_subject', 'Your account has been rejected');
        $body = get_option('rejection_email_body', 'Hello {username},<br><br>We regret to inform you that your account has been rejected. If you have any questions, please contact support.');
        $body = str_replace('{username}', $user->user_login, $body);
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Send the email
        wp_mail($user->user_email, $subject, $body, $headers);
    } else {
        // Display an error message if the current user doesn't have permission to delete users
        wp_die(__('You do not have permission to delete users.', 'textdomain'));
    }

    // Redirect to the user approvals page after deletion
    wp_redirect(admin_url('users.php?page=user-approvals'));
    exit;
}

// Send pending approval email when user registers
add_action('user_register', 'send_pending_approval_email');
function send_pending_approval_email($user_id) {
    $user = get_userdata($user_id);
    $admin_email = 'customerservice@samsonmedtech.com,mateo.e@samsonmedtech.com';

    // Retrieve user meta data
    $clinic_name = get_user_meta($user_id, 'clinic_name', true);
    $abn_nzbn = get_user_meta($user_id, 'abn_nzbn', true);

    // User notification email
    $subject = get_option('pending_approval_email_subject', 'Your account is pending approval');
    $body = get_option('pending_approval_email_body', 'Hello {username},<br><br>Your account is pending approval.');
    $body = str_replace('{username}', $user->user_login, $body);
    $headers = array('Content-Type: text/html; charset=UTF-8');

    // Send user email
    wp_mail($user->user_email, $subject, $body, $headers);

    // Admin notification email
    $admin_subject = get_option('admin_pending_approval_email_subject', 'New User Registration Pending Approval');
    $admin_body = get_option('admin_pending_approval_email_body', 'A new user has registered and is pending approval.<br><br>Username: {username}<br>Email: {email}<br>Clinic Name: {clinic_name}<br>ABN/NZBN: {abn_nzbn}');

    // Replace placeholders with actual values
    $admin_body = str_replace(
        array('{username}', '{email}', '{clinic_name}', '{abn_nzbn}'),
        array(
            $user->user_login, 
            $user->user_email, 
            !empty($clinic_name) ? $clinic_name : 'N/A', 
            !empty($abn_nzbn) ? $abn_nzbn : 'N/A'
        ), 
        $admin_body
    );

    // Send admin email
    wp_mail($admin_email, $admin_subject, $admin_body, $headers);
}


// Add custom fields to the user profile page
add_action('show_user_profile', 'add_abn_nzbn_user_profile_fields');
add_action('edit_user_profile', 'add_abn_nzbn_user_profile_fields');

function add_abn_nzbn_user_profile_fields($user) {
    ?>
    <h3><?php _e('Custom User Information', 'textdomain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="clinic_name"><?php _e('Clinic Name', 'textdomain'); ?></label></th>
            <td><input type="text" name="clinic_name" id="clinic_name" value="<?php echo esc_attr(get_user_meta($user->ID, 'clinic_name', true)); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="abn_nzbn"><?php _e('ABN/NZBN', 'textdomain'); ?></label></th>
            <td><input type="text" name="abn_nzbn" id="abn_nzbn" value="<?php echo esc_attr(get_user_meta($user->ID, 'abn_nzbn', true)); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

// Save custom user fields
add_action('personal_options_update', 'save_abn_nzbn_user_profile_fields');
add_action('edit_user_profile_update', 'save_abn_nzbn_user_profile_fields');

function save_abn_nzbn_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'clinic_name', sanitize_text_field($_POST['clinic_name']));
    update_user_meta($user_id, 'abn_nzbn', sanitize_text_field($_POST['abn_nzbn']));
}

