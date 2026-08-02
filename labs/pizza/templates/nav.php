<?php
require_once 'models/Auth.php';
$current = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '';
$auth = new Auth();

$isLoggedIn = $auth->isLoggedIn();
$user = $auth->getUser();
error_log("User: " . print_r($user, true));
$isAdmin = $isLoggedIn && $user->role === 'admin';

function getActiveClass($current, $path, bool $ishome = false): string
{
	$normal = 'text-white hover:bg-white/15';
	$active = 'bg-white text-dominos-blue hover:bg-sky-50';
	if ($ishome && ($current === '/' || str_contains($current, 'index.php'))) {
		return $active;
	}
	return str_contains($current, $path) ? $active : $normal;
}

$navLink = 'shrink-0 whitespace-nowrap rounded-sm inline-block font-display text-xs uppercase tracking-widest no-underline px-3 py-2 text-sm';
?>

<body class="min-w-[320px] overflow-x-auto bg-cream font-body text-ink antialiased">
	<header class="bg-dominos-blue text-white">
		<div class="mx-auto flex max-w-[980px] flex-wrap items-center gap-x-3 gap-y-2 px-4 py-2 md:flex-nowrap">
			<a class="flex shrink-0 items-center gap-2 text-white no-underline hover:text-white" href="index.php">
				<img class="h-9 w-9" src="images/logo.svg" width="36" height="36" alt="" />
				<span class="hidden font-display text-xl uppercase tracking-wider min-[375px]:inline">Doomino's</span>
			</a>
			<nav
				class="order-3 w-full min-w-0 basis-full overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden md:order-none"
				aria-label="Primary">
				<ul class="flex w-max flex-nowrap gap-0.5 md:w-auto">
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'index.php', true); ?>"
							href="index.php">Home</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'about.php'); ?>" href="about.php">About</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'shop.php'); ?>" href="shop.php">Menu</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'contact.php'); ?>"
							href="contact.php">Contact</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'orders.php'); ?>"
							href="orders.php">Orders</a>
					</li>
				</ul>
			</nav>

			<div class="order-2 items-center ml-auto flex gap-2 md:order-none md:ml-auto">
				<a class="shrink-0 rounded-full bg-white px-3 py-1.5 font-display text-xs uppercase tracking-wider text-dominos-blue no-underline hover:bg-sky-50 sm:px-4 sm:text-sm md:order-none md:ml-auto"
					href="shop.php">Order</a>

				<!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
				<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
				<el-dropdown class="inline-flex">
					<button class="inline-flex py-1.5 ">
						<svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
							stroke-linecap="round">
							<!-- Top Line -->
							<path d="M4 6h16" />
							<!-- Middle Line -->
							<path d="M4 12h16" />
							<!-- Bottom Line -->
							<path d="M4 18h16" />
						</svg>
					</button>

					<el-menu anchor="bottom end" popover
						class="divide-y divide-white/10 w-50 shadow-sm origin-top-right my-1 rounded-md bg-white/4 outline-1 -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
						<div class="py-1 ">
							<?php if ($isLoggedIn): ?>
								<div
									class="border-b gap-1 items-center flex hover:cursor-default block hover:bg-white/5 px-4 py-2 text-sm text-dominos-blue  hover:outline-hidden">
									<svg class="inline-flex" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
										<path d="M0 0h20v20H0z" fill="none" />
										<path fill="currentColor"
											d="M10 9.25c-2.27 0-2.73-3.44-2.73-3.44C7 4.02 7.82 2 9.97 2c2.16 0 2.98 2.02 2.71 3.81c0 0-.41 3.44-2.68 3.44m0 2.57L12.72 10c2.39 0 4.52 2.33 4.52 4.53v2.49s-3.65 1.13-7.24 1.13c-3.65 0-7.24-1.13-7.24-1.13v-2.49c0-2.25 1.94-4.48 4.47-4.48z" />
									</svg>
									<span>
										<?php echo htmlspecialchars($user->username); ?>
									</span>
								</div>
								<a class=" hover:cursor-pointer block hover:bg-white/5 px-4 py-2 text-sm text-red-600 hover:text-dominos-red hover:outline-hidden"
									href="auth.php?action=logout">
									logout
								</a>
							<?php else: ?>
								<a class="hover:cursor-pointer block hover:bg-white/5 px-4 py-2 text-sm text-dominos-blue   hover:text-dominos-blue-deep hover:outline-hidden"
									href="auth.php?action=login">
									Login
								</a>
								<a class="hover:cursor-pointer block hover:bg-white/5 px-4 py-2 text-sm text-dominos-blue   hover:text-dominos-blue-deep hover:outline-hidden"
									href="auth.php?action=register">
									Register
								</a>
							<?php endif; ?>
						</div>
					</el-menu>
				</el-dropdown>





			</div>


		</div>
	</header>