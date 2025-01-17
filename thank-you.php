<?php
/*
Template Name: Thank You Page
*/

get_header();
?>

<style>
.thank-you-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100% !important; /* Force full width */
    height: 80vh;
    text-align: center;
    background-image: url('https://maxifore.com.au/wp-content/uploads/2024/07/bg-content-page.svg');
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;}
</style>

<div class="thank-you-container">
    <h1>Thank You for Registering with MaxiFore!</h1>
    <p>Your registration was successful. Your account is pending approval.</p>
    <p>You will be redirected to the home page in <span id="countdown">5</span> seconds.</p>
    <p>If not automatically redirected, <a href="<?php echo home_url(); ?>">click here</a>.</p>
</div>

<script>
    // Countdown timer
    var countdownElement = document.getElementById('countdown');
    var countdownTime = 5;

    var countdownInterval = setInterval(function() {
        countdownTime--;
        countdownElement.textContent = countdownTime;

        // Redirect when countdown reaches 0
        if (countdownTime <= 0) {
            clearInterval(countdownInterval);
            window.location.href = '<?php echo home_url(); ?>';
        }
    }, 1000);
</script>

<?php
get_footer();
?>
