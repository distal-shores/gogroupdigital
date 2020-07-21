<?php

const GOOGLE_CLIENT_ID = '1020694055213-jmms83urrohif9hvhi2dre3ebe2n1oig.apps.googleusercontent.com';

/**
 * Customize the login page to match site branding, link to homepage instead of wordpress.org
 *
 * @package theme
 * @subpackage boilerplate-theme_filters+hooks
 * @internal called by add_filter( 'login_head', 'theme_custom_login_logo' );
 *
 */
function theme_custom_login_logo()
{
	$logo = false;

	// Create the URL of the logo
	$possible_logos = array(
		'/images/logo-login.png',
		'/images/sprites/common-1x/logo.png',
		'/images/sprites/common-compatibility/logo.png',
		'/images/logo.png',
		'/logo.png'
	);

	// Find the logo!
	foreach ( $possible_logos as $option ) {
		if ( file_exists( get_template_directory() . $option ) ) {
			$logo = $option;
			break;
		}
	}

	// If the logo exists, do some admin CSS
	if ( $logo ):
		// Get the image dimensions
		$logo_dimensions = getimagesize(get_template_directory() . $logo);
		$logo_height = isset($logo_dimensions[1]) ? $logo_dimensions[1] : '92';
		$logo_height = $logo_height . 'px';
	?>
		<script>
			function onSignIn(googleUser) {
				// POST to login url with Google id_token to handle Google login
				var id_token = googleUser.getAuthResponse().id_token;
				// NOTE: We only want the id_token, so sign the user out so the don't auto-login later.
				var auth2 = gapi.auth2.getAuthInstance();
		    auth2.signOut();

				// NOTE: Apparently to make a POST request, it has to be done through a form
				//  element. So we create a hidden one and submit it.

				var form = document.createElement('form');
				form.style.visibility = 'hidden';
				form.method = 'POST';
				form.action = '<?= wp_login_url() . '?google_redirect'; ?>';

				var input = document.createElement('input');
				input.name = 'idtoken';
				input.value = id_token;

				form.appendChild(input);
				document.body.appendChild(form);
				form.submit();
			}
		</script>
		<script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
		<meta name="google-signin-client_id" content="<?= GOOGLE_CLIENT_ID ?>">
		<style type="text/css">
			.login h1 a {
				background-image:url('<?php echo get_template_directory_uri() . $logo; ?>');
				height: <?php echo $logo_height; ?>;
				width: auto;
				margin-bottom: 0;
				background-size: initial;
				padding-bottom: 20px;
			}

			body.login {
				background-color: #fff;
			}
			#nav,#backtoblog,#notapartner {
				text-align: center;
			}
			.g-signin2 {
				display: flex;
				justify-content: center;
				margin-bottom: 20px;
			}
			.g-signin2 > div {
				width: 100% !important;
			}
			.failure {
				text-align: center;
				background-color: #f55;
				color: white;
				padding: 10px;
				margin-bottom: 20px !important;
				border-radius: 5px;
			}
		</style>

	<?php endif;
}
add_filter( 'login_head', 'theme_custom_login_logo' );

/**
 * Change the url when clicking login logo
 *
 * @package theme
 * @subpackage boilerplate-theme_filters+hooks
 * @internal called by login_headerurl filter
 *
 */
function theme_custom_login_url(){
	return get_bloginfo('url');
}
add_filter('login_headerurl', 'theme_custom_login_url');

/**
 * Customize the login title
 *
 * @package theme
 * @subpackage boilerplate-theme_filters+hooks
 * @internal called by login_headertitle filter
 *
 */
function theme_custom_login_title() {
	return get_bloginfo('name');
}
add_filter('login_headertitle', 'theme_custom_login_title');

add_action('login_form', 'do_login_form');
function do_login_form()
{
	ob_start();
	?>
		<div class="g-signin2" data-theme="dark" data-height="40" data-longtitle="true" data-onsuccess="onSignIn"></div>
	<?php
	$google_failure = isset($_GET['google_failure']) ? $_GET['google_failure'] : null;
	if ($google_failure) {
		$valid_errors = array(
			'no_user' => 'No user exists',
			'invalid_domain' => 'Invalid domain',
			'no_payload' => 'Failed to get account information'
		);
		$failureMessage = isset($valid_errors[$google_failure]) ? $valid_errors[$google_failure] : 'Failed to login';
		?>
			<p class="failure"><?= $failureMessage ?></p>
		<?php
	}
	ob_flush();
	return ob_get_clean();
}

const VALID_GOOGLE_LOGIN_DOMAINS = array(
	'gogroupdigital.com' => 'strategic_partner',
	'widerfunnel.com' => 'strategic_partner',
	'konversionskraft.de' => 'strategic_partner',
	'conversion.com' => 'strategic_partner',
	'newrepublique.com' => 'strategic_partner',
	'conversionista.se' => 'associate_partner',
	'optiphoenix.com' => 'associate_partner',
);

/**
 * Handle the Google login redirect.
 * If the Google email is already tied to an account, log it in.
 * Otherwise, create an account for the user ONLY if they are part of one of the
 * pre-accepted organizations. `VALID_GOOGLE_LOGIN_DOMAINS`
 *
 * On error, redirect to login page with query param `google_failure`.
 */
add_action('init', 'handle_google_login');
function handle_google_login()
{
	if (isset($_GET['google_redirect']) && isset($_POST['idtoken'])) {
		// require_once 'google-api-php-client-2.5.0/vendor/autoload.php';
		require_once 'google_auth/autoload.php';
		$id_token = $_POST['idtoken'];
		$redirect = wp_login_url() . '?google_failure=no_user';

		// $client = new Google_Client(['client_id' => GOOGLE_CLIENT_ID]);
		// $payload = $client->verifyIdToken($id_token);
		$auth = new \Google\Auth\AccessToken();
		$payload = $auth->verify($id_token);
		if ($payload) {
			$email = $payload['email'];
			$user = get_user_by('email', $email);
			if (!$user) {
				$email_parts = explode('@', $email);
				if (count($email_parts == 2)) {
					$domain = strtolower($email_parts[1]);
					if (array_key_exists($domain, VALID_GOOGLE_LOGIN_DOMAINS)) {
						$first_name = $payload['given_name'];
						$last_name = $payload['family_name'];
						$display_name = "$first_name $last_name";
						$userdata = array(
							'user_pass' => wp_generate_password(16),
							'user_login' => $email_parts[0],
							'user_email' => $email,
							'display_name' => $display_name,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'user_registered' => date('Y-m-d H:i:s'),
							'role' => VALID_GOOGLE_LOGIN_DOMAINS[$domain]
						);
						$insert_user_result = wp_insert_user($userdata);
						if (is_wp_error($insert_user_result)) {
							error_log($insert_user_result->get_error_message());
						} else {
							$user = get_user_by('id', $insert_user_result);
						}
					} else {
						$redirect = wp_login_url() . '?google_failure=invalid_domain';
					}
				}
			}
			if ($user) {
				wp_set_current_user($user->ID, $user->user_login);
				wp_set_auth_cookie($user->ID);
				do_action('wp_login', $user->user_login, $user);
				$redirect = home_url('insights');
			}
		} else {
			$redirect = wp_login_url() . '?google_failure=no_payload';
		}

		wp_redirect($redirect);
		exit;
	}
}
