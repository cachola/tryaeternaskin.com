<?php

namespace Application;

use GO\Scheduler;
use Application\Registry;

class Cron
{

	public static function getAssignedSchedules()
	{
		$systemCrons = Registry::system('crons');
		$extensionCrons = Registry::extension('crons');
		$extensionCronsStructured = array();

		if (!empty($extensionCrons))
		{
			foreach ($extensionCrons as $crons)
			{
				foreach ($crons as $cron)
				{
					$extensionCronsStructured[] = $cron;
				}
			}
		}

		return array_merge($systemCrons, $extensionCronsStructured);
	}

	public static function init()
	{
		$scheduler = new Scheduler();

		/**
		 * Loop thru each cron and trigger the respective handlers
		 * Will be bypass if the cron expression at $cron['every'] doesnt match
		 */
		foreach (self::getAssignedSchedules() as $cron)
		{

			$scheduler
				->call(function() use ($cron)
				{

					if (!empty($cron['handler']))
					{

						$handler = explode('@', $cron['handler']);
						return call_user_func_array(array(new $handler[0], $handler[1]), array());
					}
				})
				->at($cron['every']);
		}

		$scheduler->run();
	}

}
