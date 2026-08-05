<?php
require_once 'models/Auth.php';
$current = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '';
$auth = new Auth();

$isLoggedIn = $auth->isLoggedIn();

try {
	$user = $auth->getUser();
	$isAdmin = $auth->isAdmin();
} catch (Exception $e) {
	if (!str_contains($_SERVER['REQUEST_URI'], 'status.php')) {
		header('Location: status.php?message=' . urlencode($e->getMessage()));
		exit;
	}
	$isAdmin = false;
}

function getActiveClass($current, $path, bool $ishome = false): string
{
	$normal = 'text-white/90 hover:bg-white/10';
	$active = 'bg-dominos-red text-white hover:bg-dominos-red-deep';
	if ($ishome && ($current === '/' || str_contains($current, 'index.php'))) {
		return $active;
	}
	if ($path === 'shop.php' && str_contains($current, 'detail.php')) {
		return $active;
	}
	return str_contains($current, $path) ? $active : $normal;
}

$navLink = 'shrink-0 whitespace-nowrap rounded-sm inline-block px-2 py-2 font-display text-xs uppercase tracking-widest no-underline sm:text-sm';
?>

<body class="min-w-[320px] overflow-x-auto bg-cream font-body text-ink antialiased">
	<header class="bg-dominos-blue text-white">
		<div class="border-b border-white/20">
			<?php if (!$isLoggedIn): ?>
				<form method="POST" action="auth.php" class="grid w-full grid-cols-1 gap-2 px-2 py-2 md:grid-cols-[8fr_2fr]">
					<input type="hidden" name="action" value="login" />
					<div class="grid grid-cols-2 gap-2">
						<div class="md:flex-1">
							<label class="sr-only" for="header-username">Username</label>
							<input id="header-username" name="username" type="text" required placeholder="Username"
								class="w-full rounded-sm border border-line bg-white px-3 py-2 text-sm text-ink outline-none focus:border-dominos-blue focus:ring-1 focus:ring-dominos-blue" />
						</div>
						<div class="md:flex-1">
							<label class="sr-only" for="header-password">Password</label>
							<input id="header-password" name="password" type="password" required placeholder="Password"
								class="w-full rounded-sm border border-line bg-white px-3 py-2 text-sm text-ink outline-none focus:border-dominos-blue focus:ring-1 focus:ring-dominos-blue" />
						</div>
					</div>
					<div class="flex gap-2 md:shrink-0">
						<button type="submit"
							class="w-full rounded-sm bg-white px-4 py-2 font-display text-xs uppercase tracking-wider text-dominos-blue hover:bg-panel md:w-28">
							Login
						</button>
						<a class="w-full rounded-sm bg-white px-4 py-2 text-center font-display text-xs uppercase tracking-wider text-dominos-blue no-underline hover:bg-panel md:w-28"
							href="auth.php?act=register">Register</a>
					</div>
				</form>
			<?php else: ?>
				<div class="flex flex-col gap-2 px-2 py-2 sm:flex-row sm:items-center sm:justify-between">
					<div class="flex items-center gap-2 text-sm">
						<?php if (isset($user)): ?>
							<span class="font-display uppercase tracking-wide text-white/90">
								Hello, <?php echo htmlspecialchars($user->username); ?>
							</span>
						<?php endif; ?>
						<?php if ($isAdmin): ?>
							<span class="inline-flex items-center rounded-full bg-white/10 px-2 py-0.5 text-xs uppercase tracking-wider text-white">Admin</span>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="mx-auto flex w-full flex-wrap items-center gap-x-3 gap-y-2 px-4 py-2 md:flex-nowrap">
			<a class="flex shrink-0 items-center gap-2 text-white no-underline hover:text-white" href="index.php">
				<img class="h-9 w-9" src="images/logo.svg" width="36" height="36" alt="" />
				<span class="hidden font-display text-xl uppercase tracking-wider min-[375px]:inline">Inventory</span>
			</a>
			<nav
				class="order-3 w-full min-w-0 basis-full overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden md:order-none"
				aria-label="Primary"
			>
				<ul class="flex w-max flex-nowrap gap-0.5 md:w-auto">
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'index.php', true); ?>" href="index.php">Home</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'shop.php'); ?>" href="shop.php">Menu</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'product.php'); ?>" href="product.php">Inventory</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'users.php'); ?>" href="users.php">Users</a>
					</li>
				</ul>
			</nav>

			<div class="order-2 ml-auto flex items-center gap-2 md:order-none">
				<a class="shrink-0 rounded-sm bg-dominos-red px-3 py-1.5 font-display text-xs uppercase tracking-wider text-white no-underline hover:bg-dominos-red-deep sm:px-4 sm:text-sm"
					href="shop.php">Menu</a>
				<el-dropdown class="inline-flex">
					<button class="relative inline-flex py-1.5" type="button" aria-label="Account menu">
						<svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
							<path d="M4 6h16" />
							<path d="M4 12h16" />
							<path d="M4 18h16" />
						</svg>
						<?php if (!$isLoggedIn): ?>
							<svg class="absolute right-[-5px] top-[5px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
								width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" aria-hidden="true">
								<path d="M7 11V7a5 5 0 0 1 10 0v4" />
								<rect x="5" y="11" width="14" height="10" rx="2" />
							</svg>
						<?php endif; ?>
					</button>
					<el-menu
						anchor="bottom end"
						popover
						class="my-1 w-50 origin-top-right divide-y divide-white/10 rounded-md bg-white/4 shadow-sm outline-1 -outline-offset-1 outline-white/10"
					>
						<div class="py-1">
							<?php if ($isLoggedIn && isset($user)): ?>
								<div class="flex items-center gap-1 border-b px-4 py-2 text-sm text-dominos-blue">
									<span><?php echo htmlspecialchars($user->username); ?></span>
								</div>
								<a class="block px-4 py-2 text-sm text-red-600 no-underline hover:bg-white/5 hover:text-dominos-red"
									href="auth.php?act=logout">Logout</a>
							<?php else: ?>
								<a class="block px-4 py-2 text-sm text-dominos-blue no-underline hover:bg-white/5"
									href="auth.php?act=login">Login</a>
								<a class="block px-4 py-2 text-sm text-dominos-blue no-underline hover:bg-white/5"
									href="auth.php?act=register">Register</a>
							<?php endif; ?>
						</div>
					</el-menu>
				</el-dropdown>
			</div>
		</div>
	</header>
