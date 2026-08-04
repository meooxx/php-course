<?php
require_once __DIR__ . '/../models/Auth.php';

class AuthController
{
	private $auth;

	public function __construct()
	{
		$this->auth = new Auth();
	}

	public function handlePost($post)
	{
		$action = $post['action'] ?? '';

		if ($action == 'register') {
			$this->create($post);
		}
		if ($action == 'login') {
			$this->login($post);
		}
		if ($action == 'delete') {
			$this->delete($post);
		}
		if ($action == 'update') {
			$this->update($post);
		}
	}

	public function handleGet($get)
	{
		$pageType = isset($get['act']) ? strtolower($get['act']) : 'login';
		$username = '';
		$email = '';
		$role = 'user';
		$pendingUpdateUserId = null;

		if ($pageType == 'logout') {
			$this->logout();
		}

		if ($pageType === 'update') {
			$pendingUpdateUserId = $get['id'] ?? null;
			$userData = $this->read($pendingUpdateUserId);
			$username = $userData['username'];
			$email = $userData['email'];
			$role = $userData['role'];
			$pendingUpdateUserId = $userData['pendingUpdateUserId'];
		}

		$pageStr = ucfirst($pageType);
		$pageTitle = "Doomino's | $pageStr";
		$pageDescription = $pageType === 'register'
			? 'Create an account to place orders.'
			: ($pageType === 'login'
				? 'Access your account to place orders.'
				: 'Update your profile information.');

		$viewerAuth = new Auth();
		$canAssignAdminRole = $viewerAuth->isAdmin();

		return [
			'pageType' => $pageType,
			'pageStr' => $pageStr,
			'pageTitle' => $pageTitle,
			'pageDescription' => $pageDescription,
			'canAssignAdminRole' => $canAssignAdminRole,
			'username' => $username,
			'email' => $email,
			'role' => $role,
			'pendingUpdateUserId' => $pendingUpdateUserId,
		];
	}

	public function create($post)
	{
		$username = trim($post['username'] ?? '');
		$password = trim($post['password'] ?? '');
		$confirmPassword = trim($post['confirm_password'] ?? '');
		$email = trim($post['email'] ?? '');
		$role = trim($post['role'] ?? 'user');
		$auth = new Auth();
		try {
			$result = $auth->register($username, $password, $confirmPassword, $email, $role);
			if ($result !== false) {
				header('Location: index.php');
				exit;
			}
		} catch (Exception $e) {
			header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
			exit;
		}
		exit;
	}

	public function read($userId)
	{
		if (isset($userId)) {
			$auth = new Auth();
			try {
				$pendingUpdateUser = $auth->getUserById($userId);
				if (!$pendingUpdateUser) {
					throw new Exception('User not found');
				}
				return [
					'pendingUpdateUserId' => $userId,
					'username' => $pendingUpdateUser->username,
					'email' => $pendingUpdateUser->email,
					'role' => $pendingUpdateUser->role,
				];
			} catch (Exception $e) {
				header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
				exit;
			}
		}

		header('Location: status.php?success=0&message=Invalid request.');
		exit;
	}

	public function update($post)
	{
		$auth = new Auth();
		$username = trim($post['username'] ?? '');
		$email = trim($post['email'] ?? '');
		$targetId = trim($post['userId'] ?? '');
		$role = trim($post['role'] ?? '');
		try {
			$auth->updateUser($targetId, $username, $email, $role);
			header('Location: status.php?success=1&message=Profile updated successfully.');
			exit;
		} catch (Exception $e) {
			header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
			exit;
		}
	}

	public function delete($post)
	{
		$auth = new Auth();
		$targetUserId = $post['targetUserId'] ?? null;
		if (isset($targetUserId)) {
			try {
				$auth->deleteUser($targetUserId);
				header('Location: status.php?success=1&message=User deleted successfully.');
				exit;
			} catch (Exception $e) {
				header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
				exit;
			}
		} else {
			header('Location: status.php?success=0&message=Invalid request.');
			exit;
		}
		exit;
	}

	public function login($post)
	{
		$username = trim($post['username'] ?? '');
		$password = trim($post['password'] ?? '');
		$auth = new Auth();
		try {
			$result = $auth->login($username, $password);
			if ($result !== false) {
				header('Location: index.php');
				exit;
			}
		} catch (Exception $e) {
			header('Location: status.php?success=0&message=' . urlencode($e->getMessage()));
			exit;
		}
		exit;
	}

	public function logout()
	{
		$auth = new Auth();
		$auth->logout();
		header('Location: index.php');
		exit;
	}
}
