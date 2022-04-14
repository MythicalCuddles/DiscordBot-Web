<body>
    <div class="container" align="center">
    	<p>
    		<hr />
    		Developed by <a href="https://mythicalcuddles.xyz" target="_blank">Melissa Brennan</a>
    		<br />
    		<img class="mb-4" src="https://imgserv.mythicalcuddles.xyz/Signature.png" alt="" height="45">
            <br />
    		<?php
    		$config = require('config.php');

    		if($config['support']['PAYPAL_SUPPORT'] || $config['support']['PATREON_SUPPORT'])
    		{
    			if($config['support']['PAYPAL_SUPPORT'])
    			{
    				echo '<a href="https://www.paypal.me/mythicalcuddles" target="_BLANK"><img alt="Support/PayPal" src="https://img.shields.io/badge/Support%20the%20Developer-Donate%20via%20PayPal-ffa329.svg" /></a>';

    				if($config['support']['PATREON_SUPPORT']) echo ' ';
    			}

    			if($config['support']['PATREON_SUPPORT'])
    			{
    				echo '<a href="https://www.patreon.com/mythicalcuddles" target="_BLANK"><img alt="Support/Patreon" src="https://img.shields.io/badge/Support%20the%20Developer-Become%20a%20Patreon-ffa329.svg" /></a>';
    			}

    			echo '<br />';
    		}

    		echo '
    			<a href="https://github.com/MythicalCuddles/DiscordBot" target="_BLANK"><img alt="GitHub/DiscordBot" src="https://img.shields.io/badge/DiscordBot-v' . $config['version']['DISCORDBOT_VERSION'] . '-blue.svg"></a>
    			<a href="https://github.com/MythicalCuddles/DiscordBot-Web-Private" target="_BLANK"><img alt="GitHub/DiscordBotWeb" src="https://img.shields.io/badge/DiscordBot%20Web-v' . $config['version']['DISCORDBOT_WEB_VERSION'] . '-blue.svg"></a>
    		';
            //<a href="privacy.php"><img alt="Privacy Policy" src="https://img.shields.io/badge/Documentation-Privacy%20Policy-orange.svg"></a>
            //<a href="https://github.com/MythicalCuddles/DiscordBot-Web-Private/blob/master/LICENSE" target="_BLANK"><img alt="License" src="https://img.shields.io/badge/Documentation-GPU%20v3.0%20License-orange.svg"></a>
    		?>
    	</p>
    </div>
</body>
