<?php
require_once 'models/Auth.php';
$auth = new Auth();
$auth->requireAdmin();
$isLoggedIn = $auth->isLoggedIn();
$showAdminFeatures = $auth->isAdmin();
$currentUser = $auth->getUser();

$users = [];
$pageTitle = "Doomino's | Users";
$pageDescription = 'View and manage users in the system.';
try {
	$users = $auth->getUsers();
} catch (Exception $e) {
	header("Location: status.php?success=0&message={$e->getMessage()}");
	exit;
}

$totalUsers = count($users);


require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="flex flex-wrap items-end justify-between gap-3 pb-4 pt-7">
		<div>
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Users
			</h1>
			<p class="mt-1 text-muted">Staff and customer roster.</p>
		</div>
		<?php if ($showAdminFeatures): ?>
			<a class="shrink-0 rounded-sm bg-dominos-blue px-4 py-1.5 font-display text-sm tracking-wider text-white no-underline hover:bg-dominos-blue-deep"
				href="auth.php?act=add_user">+ Add user</a>
		<?php endif; ?>
	</div>
	<?php if ($totalUsers === 0) { ?>
		<p class="border border-line bg-white px-4 py-8 text-center text-muted">
			No users yet.
			<a class="text-dominos-blue underline-offset-2 hover:underline" href="auth.php?act=register">Register one</a>
		</p>
	<?php } else { ?>
		<ul class="flex flex-col gap-3">
			<?php foreach ($users as $user) {
				$isAdminRole = ($user->role ?? '') === 'admin';
				$initial = strtoupper(substr($user->username ?? '?', 0, 1));
				$isSelf = isset($currentUser) && (int) $currentUser->id === (int) $user->id;
				$avatarClass = $isAdminRole
					? 'bg-dominos-red text-white'
					: 'bg-dominos-blue text-white';
				$roleClass = $isAdminRole
					? 'bg-dominos-red text-white'
					: 'bg-panel text-ink';
				?>
				<li class="overflow-hidden rounded-sm border border-line bg-white">
					<div class="flex flex-col gap-3 p-3.5 sm:flex-row sm:items-center sm:gap-4 sm:p-4">
						<div class="flex min-w-0 flex-1 items-center gap-3">
							<div
								class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full font-display text-xl uppercase <?php echo $avatarClass; ?>">
								<?php echo htmlspecialchars($initial); ?>
							</div>
							<div class="min-w-0">
								<div class="flex flex-wrap items-center gap-2">
									<h3 class="font-display text-lg uppercase tracking-wide text-dominos-blue">
										<?php echo htmlspecialchars($user->username); ?>
									</h3>
									<?php if ($isSelf): ?>
										<span
											class="rounded-sm bg-panel px-1.5 py-0.5 text-[10px] font-display uppercase tracking-wider text-dominos-blue-deep">You</span>
									<?php endif; ?>
								</div>
								<p class="truncate text-sm text-muted">
									<?php echo htmlspecialchars($user->email); ?>
								</p>
								<p class="mt-0.5 text-xs text-muted">#<?php echo (int) $user->id; ?></p>
							</div>
						</div>

						<div class=" flex flex-wrap items-center justify-between gap-3 sm:justify-end">
							<span class="min-w-20 text-center rounded-sm px-2 py-1 font-display text-xs uppercase tracking-wider <?php echo $roleClass; ?>">
								<?php echo $isAdminRole ? 'Admin' : 'Customer'; ?>
							</span>

							<?php if ($showAdminFeatures): ?>
								<div class="flex items-center gap-2">
									<a href="auth.php?act=update&id=<?php echo (int) $user->id; ?>"
										class="rounded-sm border border-dominos-blue px-3 py-1.5 font-display text-xs uppercase tracking-wider text-dominos-blue no-underline hover:bg-panel">Edit</a>
									<form method="POST" action="auth.php" class="inline">
										<input type="hidden" name="action" value="delete" />
										<input type="hidden" name="targetUserId" value="<?php echo (int) $user->id; ?>" />
										<button type="submit"
											class="rounded-sm border border-dominos-red px-3 py-1.5 font-display text-xs uppercase tracking-wider text-dominos-red hover:bg-dominos-red-soft">Del</button>
									</form>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>
</main>

<?php require_once 'templates/footer.php'; ?>