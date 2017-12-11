<?php
/**
 * Elgg notifications plugin index
 *
 * @package ElggNotifications
 *
 * @uses $user ElggUser
 */

$current_user = elgg_get_logged_in_user_entity();
$username = elgg_extract('username', $vars);
$user = get_user_by_username($username);
if (($user->guid != $current_user->guid) && !$current_user->isAdmin()) {
	forward();
}

if (!isset($user) || !($user instanceof ElggUser)) {
	$url = 'notifications/personal/' . elgg_get_logged_in_user_entity()->username;
	forward($url);
}

elgg_set_page_owner_guid($user->guid);

$title = elgg_echo('notifications:subscriptions:changesettings');

elgg_push_breadcrumb(elgg_echo('settings'), "settings/user/{$user->username}");

$content = elgg_view('notifications/personal', [
	'user' => $user,
]);

$layout = elgg_view_layout('one_sidebar', [
	'content' => $content,
	'title' => $title,
	'show_owner_block_menu' => false,
]);

echo elgg_view_page($title, $layout);
