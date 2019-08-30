<?PHP

/**
 * Throttle anything you want, to prevent flooding.
 * PHP 7.0 is a minimum requirement.
 * forked from: https://github.com/jakiestfu/Throttle
 */
function throttle($opt) {

	if (is_array($opt) && isset($opt['id']) && isset($opt['throttled'])) {
		$now = time();
		$id  = $opt['id'];

		$runsAllowed = $opt['runsAllowed'] ?? 1;
		$runsForTime = $opt['runsForTime'] ?? 20;
		$throttleFor = $opt['throttleFor'] ?? 60;
		$throttleKey = $opt['throttleKey'] ?? 'throttled';
		
		if (isset($_SESSION[$throttleKey][$id]['blockedUntil'])) {
			$timeLeft    = $now - $_SESSION[$throttleKey][$id]['blockedUntil'];
			$secondsLeft = $timeLeft * -1;
			
			if ($timeLeft < 0) {
				$opt['throttled']($secondsLeft);

			} else {
				$_SESSION[$throttleKey][$id] = [
					'startedAt' => $now,
					'runsCount' => 1
				];
				
				if ($_SESSION[$throttleKey][$id]['runsCount'] == $runsAllowed) {
					$_SESSION[$throttleKey][$id]['blockedUntil'] = $now + $throttleFor;
				}
			}

		} else {
			if (! isset($_SESSION[$throttleKey][$id]['startedAt'])) {
				$_SESSION[$throttleKey][$id]['startedAt'] = $now;

			} else {
				if ($now > ($_SESSION[$throttleKey][$id]['startedAt'] + $runsForTime)) {
					$_SESSION[$throttleKey][$id] = [
						'startedAt' => $now,
						'runsCount' => 0
					];
				}
			}
			
			isset($_SESSION[$throttleKey][$id]['runsCount'])
				? $_SESSION[$throttleKey][$id]['runsCount']++
				: $_SESSION[$throttleKey][$id]['runsCount'] = 1;
			
			if ($_SESSION[$throttleKey][$id]['runsCount'] == $runsAllowed) {
				$_SESSION[$throttleKey][$id]['blockedUntil'] = $now + $throttleFor;
			}
		}

	} else {
		throw new Exception("Reqired throttle parameters not met!");
	}
}