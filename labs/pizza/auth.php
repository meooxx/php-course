<?php

require_once 'models/Auth.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST['action'] == 'register') {


		$username = trim($_POST['username'] ?? '');
		$password = trim($_POST['password'] ?? '');
		$confirmPassword = trim($_POST['confirm_password'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$auth = new Auth();
		try {
			$result = $auth->register($username, $password, $confirmPassword, $email);
			if ($result !== false) {
				header('Location: index.php');
				exit;
			}
		} catch (Exception $e) {
			header("Location: status.php?success=0&message={$e->getMessage()}");
			exit;
		}
	}
	if ($_POST['action'] == 'login') {

		$username = trim($_POST['username'] ?? '');
		$password = trim($_POST['password'] ?? '');
		$auth = new Auth();
		try {
			$result = $auth->login($username, $password);
			if ($result !== false) {
				header('Location: index.php');
				exit;
			}
		} catch (Exception $e) {
			header("Location: status.php?success=0&message={$e->getMessage()}");
			exit;
		}
	}

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$pageType = isset($_GET['action']) ? strToLower($_GET['action']) : 'LOGIN'; // default to 'LOGIN' if not specified
	if($pageType == 'logout') {
		$auth = new Auth();
		$auth->logout();
		header('Location: index.php');
		exit;
	}
	// convert to 'Login' | 'Register' for display
	$pageStr = ucfirst($pageType);
	$pageTitle = "Doomino's | $pageStr";
}

?>

<?php require_once 'templates/header.php'; ?>
<?php require_once 'templates/nav.php'; ?>
<?php if ($pageType === 'register') { ?>
	<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
		<div class="pb-4 pt-7">
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Register
			</h1>
			<p class="mt-1 text-muted">Create an account to place orders.</p>
		</div>
		<form method="POST" action="auth.php" class="max-w-sm space-y-4">
			<input type="hidden" name="action" value="register" />
			<div>
				<label for="username" class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Username</label>
				<input type="text" name="username" id="username" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($username ?? ''); ?>" />
			</div>
			<div>
				<label for="email" class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Email</label>
				<input type="email" name="email" id="email" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($email ?? ''); ?>" />
			</div>
			<div>
				<label for="password" class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Password</label>
				<input type="password" name="password" id="password" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="" />
			</div>
			<div>
				<label for="confirm_password" class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Confirm Password</label>
				<input type="password" name="confirm_password" id="confirm_password" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="" />
			</div>
			<div>
				<button type="submit"
					class="w-full rounded-md bg-dominos-blue px-4 py-2 text-white font-medium hover:bg-dominos-blue-deep focus:outline-none focus:ring-2 focus:ring-dominos	-blue focus:ring-offset-2">
					Register
				</button>
			</div>
		</form>
	</main>
<?php } elseif ($pageType === 'login') { ?>
	<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
		<div class="pb-4 pt-7">
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Login
			</h1>
			<p class="mt-1 text-muted">Access your account to place orders.</p>
		</div>
		<form method="POST" action="auth.php" class="max-w-sm space-y-4">
			<input type="hidden" name="action" value="login" />
			<div>
				<label for="username" class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Username</label>
				<input type="text" name="username" id="username" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($username ?? ''); ?>" />
			</div>
			<div>
				<label for="password" class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Password</label>
				<input type="password" name="password" id="password" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="" />
			</div>
			<div>
				<button type="submit"
					class="w-full rounded-md bg-dominos-blue px-4 py-2 text-white font-medium hover:bg-dominos-blue-deep focus:outline-none focus:ring-2 focus:ring-dominos-blue focus:ring-offset-2">
					Login
				</button>
			</div>
		</form>
	</main>
<?php } ?>



<?php require_once 'templates/footer.php'; ?>