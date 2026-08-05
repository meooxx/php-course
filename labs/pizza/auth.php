<?php
require_once 'controllers/AuthController.php';

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$controller->handlePost($_POST);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$view = $controller->handleGet($_GET);
	$pageType = $view['pageType'];
	$pageStr = $view['pageStr'];
	$pageTitle = $view['pageTitle'];
	$pageDescription = $view['pageDescription'];
	$canAssignAdminRole = $view['canAssignAdminRole'];
	$username = $view['username'];
	$email = $view['email'];
	$role = $view['role'];
	$pendingUpdateUserId = $view['pendingUpdateUserId'];
}
?>

<?php require_once 'templates/header.php'; ?>
<?php require_once 'templates/nav.php'; ?>
<?php if (($pageType ?? '') === 'register' || ($pageType ?? '') === 'add_user') { ?>
	<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
		<div class="pb-4 pt-7">
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Register
			</h1>
			<p class="mt-1 text-muted">Create an account to manage your profile.</p>
		</div>
		<form method="POST" action="auth.php" class="max-w-sm space-y-4">
			<input type="hidden" name="action" value="<?php echo $pageType; ?>" />
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
			<?php if (!empty($canAssignAdminRole)): ?>
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
			<?php else: ?>
				<input type="hidden" name="role" value="user" />
			<?php endif; ?>
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
					class="w-full rounded-md bg-dominos-blue px-4 py-2 text-white font-medium hover:bg-dominos-blue-deep focus:outline-none focus:ring-2 focus:ring-dominos-blue focus:ring-offset-2">
					Register
				</button>
			</div>
		</form>
	</main>
<?php }
if (($pageType ?? '') === 'login') { ?>
	<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
		<div class="pb-4 pt-7">
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Login
			</h1>
			<p class="mt-1 text-muted">Sign in to access inventory and user tools.</p>
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
if (($pageType ?? '') === 'update') { ?>
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
