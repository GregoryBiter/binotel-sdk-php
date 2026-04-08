<?php

/**
 * Примеры API CALL SETTINGS.
 * Документация: http://developers.binotel.ua/#api-call-settings
 */


/**
 * ВНИМАНИЕ!!!! В целях безопасности, откройте доступ к этому скрипту только с серверов Binotel!
 */

/**
 * List of Binotel servers
 */
$listOfBinotelServers = array(
	'194.88.218.116' => 'my.binotel.ua',
	'194.88.218.114' => 'sip1.binotel.com',
	'194.88.218.117' => 'sip2.binotel.com',
	'194.88.218.118' => 'sip3.binotel.com',
	'194.88.219.67' => 'sip4.binotel.com',
	'194.88.219.78' => 'sip5.binotel.com',
	'194.88.219.70' => 'sip6.binotel.com',
	'194.88.219.71' => 'sip7.binotel.com',
	'194.88.219.72' => 'sip8.binotel.com',
	'194.88.219.79' => 'sip9.binotel.com',
	'194.88.219.80' => 'sip10.binotel.com',
	'194.88.219.81' => 'sip11.binotel.com',
	'194.88.219.82' => 'sip12.binotel.com',
	'194.88.219.83' => 'sip13.binotel.com',
	'194.88.219.84' => 'sip14.binotel.com',
	'194.88.219.85' => 'sip15.binotel.com',
	'194.88.219.86' => 'sip16.binotel.com',
	'194.88.219.87' => 'sip17.binotel.com',
	'194.88.219.88' => 'sip18.binotel.com',
	'194.88.219.89' => 'sip19.binotel.com',
	'194.88.219.92' => 'sip20.binotel.com',
	'194.88.218.119' => 'sip21.binotel.com',
	'194.88.218.120' => 'sip22.binotel.com',
	'185.100.66.145' => 'sip50.binotel.com',
	'185.100.66.146' => 'sip51.binotel.com',
	'185.100.66.147' => 'sip52.binotel.com',
);

/**
 * Allow access only from Binotel server
 */
if (!isset($listOfBinotelServers[$_SERVER['REMOTE_ADDR']])) {
	die(sprintf('Access denied!%s', PHP_EOL));
}


$phoneNumber = (isset($_REQUEST['externalNumber']) ? trim($_REQUEST['externalNumber']) : '');

if (empty($phoneNumber)) {
	die(sprintf('Phone number is empty!%s', PHP_EOL));
}



try {
	$db = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8', 'database-host', 'database-name'), 'username', 'password');
} catch (PDOException $e) {
	die(sprintf('Error: %s %s', $e->getMessage(), PHP_EOL));
}


try {
	$stmt = $db->prepare('
							SELECT
								`id`,
								`first_name`,
								`assigned_to_id`
							FROM
								`contacts`
							WHERE
								`phone` LIKE ?
							LIMIT 0, 1
						 ');

	$stmt->execute(array('%'. $phoneNumber .'%'));
	$contactData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die(sprintf('Error: %s %s', $e->getMessage(), PHP_EOL));
}

if ($contactData) {
	try {
		$stmt = $db->prepare('
								SELECT
									`mail`
								FROM
									`users`
								WHERE
									`id` = ?
								LIMIT 0, 1
							 ');

		$stmt->execute(array($contactData['assigned_to_id']));
		$assignedManagerEmail = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		die(sprintf('Error: %s %s', $e->getMessage(), PHP_EOL));
	}

	die(json_encode(array(
		'customerData' => array(
			'name' => $contactData['first_name'],
			'assignedToEmployeeEmail' => ($assignedManagerEmail ? $assignedManagerEmail['mail'] : ''),
			'linkToCrmUrl' => sprintf('https://crm.crm.crm/contacts/%s/', $contactData['id'])
		)
	)));
}
