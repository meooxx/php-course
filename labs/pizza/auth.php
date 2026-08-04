<?php

require_once 'models/Auth.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST['action'] == 'register') {


		$username = trim($_POST['username'] ?? '');
		$password = trim($_POST['password'] ?? '');
		$confirmPassword = trim($_POST['confirm_password'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$role = trim($_POST['role'] ?? 'user');
		$auth = new Auth();
		try {
			$result = $auth->register($username, $password, $confirmPassword, $email, $role);
			if ($result !== false) {
				header('Location: index.php');
				exit;
			}
		} catch (Exception $e) {
			header("Location: status.php?success=0&message={$e->getMessage()}");
			exit;
		}
		exit;
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
		exit;
	}
	if ($_POST['action'] == 'delete') {
		$auth = new Auth();
		$userId = $_POST['userId'] ?? null;
		if (isset($userId)) {
			try {
				$auth->deleteUser($userId);
				header("Location: status.php?success=1&message=User deleted successfully.");
				exit;
			} catch (Exception $e) {
				header("Location: status.php?success=0&message={$e->getMessage()}");
				exit;
			}
		} else {
			header("Location: status.php?success=0&message=Invalid request.");
			exit;
		}
		exit;
	}
	if ($_POST['action'] == 'update') {
		$auth = new Auth();
		$username = trim($_POST['username'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$targetId = trim($_POST['userId'] ?? '');
		$role = trim($_POST['role'] ?? '');
		try {
			$auth->updateUser($targetId, $username, $email, $role);
			header("Location: status.php?success=1&message=Profile updated successfully.");
			exit;
		} catch (Exception $e) {
			header("Location: status.php?success=0&message={$e->getMessage()}");
			exit;
		}
	}

}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$pageType = isset($_GET['act']) ? strToLower($_GET['act']) : 'LOGIN'; // default to 'LOGIN' if not specified
	if ($pageType == 'logout') {
		$auth = new Auth();
		$auth->logout();
		header('Location: index.php');
		exit;
	}
	if ($pageType === 'update') {
		$auth = new Auth();
		$pendingUpdateUserId = $_GET['id'] ?? null;
		if (isset($pendingUpdateUserId)) {
			try {
				$pendingUpdateUser = $auth->getUserById($pendingUpdateUserId);
				if (!$pendingUpdateUser) {
					throw new Exception('User not found');
				}
				$username = $pendingUpdateUser->username;
				$email = $pendingUpdateUser->email;
				$role = $pendingUpdateUser->role;
			} catch (Exception $e) {
				header("Location: status.php?success=0&message={$e->getMessage()}");
				exit;
			}
		} else {
			header("Location: status.php?success=0&message=Invalid request.");
			exit;
		}
	}
	// convert to 'Login' | 'Register' for display
	$pageStr = ucfirst($pageType);
	$pageTitle = "Doomino's | $pageStr";
	$pageDescription = $pageType === 'register' ? 'Create an account to place orders.' : ($pageType === 'login' ? 'Access your account to place orders.' : 'Update your profile information.');
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
				<label for="username"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Username</label>
				<input type="text" name="username" id="username" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($username ?? ''); ?>" />
			</div>
			<div>
				<label for="email"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Email</label>
				<input type="email" name="email" id="email" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($email ?? ''); ?>" />
			</div>
			<div class="mb-3.5 flex flex-wrap gap-2">
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line  px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="role" value="admin" />
					<span>Admin</span>
				</label>
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="role" value="user" checked />
					<span>User</span>
				</label>



			</div>
			<div>
				<label for="password"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Password</label>
				<input type="password" name="password" id="password" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2" value="" />
			</div>
			<div>
				<label for="confirm_password"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Confirm Password</label>
				<input type="password" name="confirm_password" id="confirm_password" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2" value="" />
			</div>
			<div>
				<button type="submit"
					class="w-full rounded-md bg-dominos-blue px-4 py-2 text-white font-medium hover:bg-dominos-blue-deep focus:outline-none focus:ring-2 focus:ring-dominos	-blue focus:ring-offset-2">
					Register
				</button>
			</div>
		</form>
	</main>
<?php }
if ($pageType === 'login') { ?>
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
				<label for="username"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Username</label>
				<input type="text" name="username" id="username" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($username ?? ''); ?>" />
			</div>
			<div>
				<label for="password"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Password</label>
				<input type="password" name="password" id="password" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2" value="" />
			</div>
			<div>
				<button type="submit"
					class="w-full rounded-md bg-dominos-blue px-4 py-2 text-white font-medium hover:bg-dominos-blue-deep focus:outline-none focus:ring-2 focus:ring-dominos-blue focus:ring-offset-2">
					Login
				</button>
			</div>
		</form>
	</main>
<?php }
if ($pageType === 'update') { ?>
	<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
		<div class="pb-4 pt-7">
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Update Profile
			</h1>
			<p class="mt-1 text-muted">Update your profile information.</p>
		</div>
		<form method="POST" action="auth.php" class="max-w-sm space-y-4">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="userId" value="<?php echo $pendingUpdateUserId; ?>" />
			<div>
				<label for="username"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Username</label>
				<!-- I don't think users should be able to change their username -->
				<input type="text" readonly name="username" id="username" required
					class="w-full cursor-not-allowed rounded-sm border border-line bg-cream px-3 py-2"
					value="<?php echo htmlspecialchars($username ?? ''); ?>" />
			</div>
			<div>
				<label for="email"
					class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue">Email</label>
				<input type="email" name="email" id="email" required
					class="w-full rounded-sm border border-line bg-white px-3 py-2"
					value="<?php echo htmlspecialchars($email ?? ''); ?>" />
			</div>
			<div class="mb-3.5 flex flex-wrap gap-2">
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line  px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="role" value="admin" <?php echo $role == 'admin' ? 'checked' : ''; ?> />
					<span>Admin</span>
				</label>
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="role" value="user" <?php echo $role == 'user' ? 'checked' : ''; ?> />
					<span>User</span>
				</label>



			</div>
			<div>
				<button type="submit"
					class="w-full rounded-md bg-dominos-blue px-4 py-2 text-white font-medium hover:bg-dominos-blue-deep focus:outline-none focus:ring-2 focus:ring-dominos-blue focus:ring-offset-2">
					Update
				</button>
			</div>
		</form>
	</main>
<?php } ?>




<?php require_once 'templates/footer.php'; ?>