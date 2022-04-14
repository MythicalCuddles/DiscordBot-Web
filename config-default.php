<?php
/*
	Configuration File
*/
return [
	'database' => [
		'DB_HOSTNAME' => '', // Database Hostname / REQUIRED
		'DB_USERNAME' => '', // Database Username / REQUIRED
		'DB_PASSWORD' => '', // Database Password / REQUIRED
		'DB_NAME' => '' // Database Name / REQUIRED
	],

	// Create an application here: https://discordapp.com/developers/applications/
	'oAuth' => [
		'REDIRECT_URI' => '', // Redirect URI for the API Application specified in the application / REQUIRED
		'CLIENT_ID' => '', // Client ID of the API Application / REQUIRED
		'CLIENT_SECRET' => '', // Client secret of the API Application / REQUIRED
		'SCOPE' => '' // Scope for oAuth API Application (Example: identify) / REQUIRED
	],

	'global' => [
		'PAGE_TITLE_BOT_NAME' => 'DiscordBot', // Bot Name / Page Titles (x - Global Leaderboard)
		'BREADCRUMB_INDEX_TITLE' => 'DiscordBot', // Breadcrumb tag on pages such as profile.php
		'GOOGLE_ANALYTICS_ID' => '', // GOOGLE_ANALYTICS_ID which can be obtained through the analytics app via Google
	],

	'leaderboard' => [
		'LEADERBOARD_LIMIT' => 20 // Amount of users to show on the leaderboard
	],

	'bans' => [
		'BAN_RESULTS_PER_PAGE' => 10, // Amount of banned users to show per page
		'PAGES_PER_SIDE' => 2 // Number of pages to display on each side of current page (eg: 2 => [First] [Previous] [1] [2] [>3<] [4] [5] [Next] [Last])
	],

	'search' => [
		'SEARCH_RESULTS_PER_PAGE' => 15, // More may require more time to load the page (rows of 3)
		'PAGES_PER_SIDE' => 2 // Number of pages to display on each side of current page (eg: 2 => [First] [Previous] [1] [2] [>3<] [4] [5] [Next] [Last])
	],

	'support' => [
		'PAYPAL_SUPPORT' => true,
		'PATREON_SUPPORT' => true
	],

	'strings' => [
		'TEAM_MEMBER' => '<i class="fas fa-user-shield"></i> Team Member', // ⭐
		'PATREON_SUPPORTER' => '<i class="fab fa-patreon"></i> Patreon Supporter', // 💗
		'BOT_IGNORED' => '<i class="fas fa-ban"></i> Blocked User' // 🚫
	],

	'links' => [
		'DISCORD_FORMATTING_GUIDE' => 'https://support.discordapp.com/hc/en-us/articles/210298617-Markdown-Text-101-Chat-Formatting-Bold-Italic-Underline-' // Linked on account.php under about section
	],

	'version' => [
		'DISCORDBOT_VERSION' => '', // Version the C# bot is running / Visual purpose only.
		'DISCORDBOT_WEB_VERSION' => '' // Version of website / Visual purpose only.
	]
];
