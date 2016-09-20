<?
class SupportPush {
	
	const FOUR_HOURS = 14400;
	const ONE_DAY = 86400;
	const TWO_DAYS = 172800;
	const THREE_DAYS = 259200;
	const SUPPORT_TEAM_GROUP_ID = 8;
	const ADMIN_TEAM_GROUP_ID = 1;
	
	const BILLING_IBLOCK_ID = 24;
	
	const EMAIL_EVENT_TYPE = "TICKETS_NOTIFICATION";
	const EMAIL_TEMPLATE_ID = 133;

	const NEEDS_CLIENT_DECISION = 27; // статус "Требуется уточнение клиента"
	const SOLVED = 29; // статус "Разрешен"
	const ACCEPTED = 7; // статус "Принято к рассмотрению"
	const NEW_TICKET = 26; // статус "Новый тикет"
	const IN_PROGRESS = 8; // статус "В работе"
	const THIRD_PARTY_SUPPORT = 42; // статус "Общение со сторонней ТП"
	
	
	private $support_admin_ids = [];
	private $support_users = [];
	private $message = "Тикеты, требующие внимания:<br>";
	private $admin_message = "";
	private $current_test_case = 0;
	private $success_flag = false; // отсекаем пустые сообщения с помощью этого флага
	
	function __construct() {
		// Соберем ID сотрудников техподдержки
		$users = CUser::GetList (
			$by = "id",
			$order = "asc",
			[
				"GROUPS_ID" => self::SUPPORT_TEAM_GROUP_ID,
				"ACTIVE"    => "Y"
			],
			[
				"FIELDS" => ["ID", "NAME", "LAST_NAME", "EMAIL"]
			]
		);
		
		while($user = $users->Fetch()) {
			$this->support_users[$user['ID']] = [
				"NAME"  => $user['NAME'] . ' ' . $user['LAST_NAME'],
				"EMAIL" => $user['EMAIL']
			]; 
		}

		// Соберем ID админов
		$users = CUser::GetList (
			$by = "id",
			$order = "asc",
			[
				"GROUPS_ID" => self::ADMIN_TEAM_GROUP_ID,
				"ACTIVE"    => "Y"
			],
			[
				"FIELDS" => ["ID"]
			]
		);
		
		while($user = $users->Fetch()) {
			array_push($this->support_admin_ids, $user['ID']);
		}
	}
	
	/**
	 * Abstract
	 * 
	 * TODO: Возможно стоит объединить все кейсы связанные со статусом
	 * под одним методом, но должна сохраняться возможность запуска любого кейса
	 * отдельно от других
	 * 
	 * */
	private function checkStatusCases($tickets) {}
	
	/**
	 * 
	 * Первый кейс. Тикет имеет статус "Требуется уточнение клиента"
	 * и клиент ответил, но нет реакции более 4х часов от техподдежржки. 
	 * 
	 * Рассылка ответственному и администраторам
	 * 
	 * */
	private function checkFirstCase($tickets) {
		$this->current_test_case = 1;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: неверный статус;<br>';
		$filtered_tickets = array_filter($tickets, [$this, 'filterTickets']);
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Второй кейс. Тикет имеет статус "Требуется уточнение клиента"
	 * и клиент не отвечает более 3х дней, нужно напомнить. 
	 * 
	 * Рассылка ответственному и администраторам
	 * 
	 * */
	private function checkSecondCase($tickets) {
		$this->current_test_case = 2;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: нужно напомнить клиенту о задаче;<br>';
		$filtered_tickets = array_filter($tickets, [$this, 'filterTickets']);
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Третий кейс. Тикет имеет статус "Разрешен",
	 * но клиент написал в него. Нужно проверить. Уведомление через 4 часа. 
	 * 
	 * Рассылка ответственному и администраторам
	 * 
	 * */
	private function checkThirdCase($tickets) {
		$this->current_test_case = 3;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: нужно проверить актуальность тикета;<br>';
		$filtered_tickets = array_filter($tickets, [$this, 'filterTickets']);
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Четвертый кейс. Тикет создан, но у него нет ни статуса ни ответственного. 
	 * 
	 * Рассылка только администраторам.
	 * 
	 * */
	private function checkFourthCase() {
		$this->current_test_case = 4;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: тикету не присвоен статус;<br>';
		$filtered_tickets = [];
		$missed_tickets = CTicket::GetList (
			$by = "s_id",
			$order = "asc",
			[
				"STATUS_ID" => 0,
				"CLOSE"     => "N",
			],
			$is_filtered, "N", "N", "Y");
			
		while ($ticket = $missed_tickets->Fetch()) {
			$filtered_tickets[] = [
				"ID" => $ticket['ID']
			];
		}
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Пятый кейс. Тикет имеет статус "Принято к рассмотрению" или "Новый тикет",
	 * но клиент написал в него. День нет ответа. Нужно проверить. 
	 * 
	 * Рассылка ответственному и администраторам
	 * 
	 * */
	private function checkFifthCase($tickets) {
		$this->current_test_case = 5;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: необходимо взять в работу;<br>';
		$filtered_tickets = array_filter($tickets, [$this, 'filterTickets']);
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Шестой кейс. Тикет имеет статус "Общение со сторонней ТП".
	 * Последнее сообщение от клиента день назад или от сотрудника два дня назад. 
	 * 
	 * Рассылка ответственному и администраторам
	 * 
	 * */
	private function checkSixthCase($tickets) {
		$this->current_test_case = 6;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: сообщить клиенту о ходе работ;<br>';
		$filtered_tickets = array_filter($tickets, [$this, 'filterTickets']);
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Седьмой кейс. Тикет имеет статус "В работе".
	 * Тикет в работе, но уже более 2х дней нет транзакций, нужно напомнить, чтобы ответственный к нему вернулся. 
	 * 
	 * Рассылка ответственному и администраторам
	 * 
	 * */
	private function checkSeventhCase($tickets) {
		$this->current_test_case = 7;
		$case_message_template = '- <a href="http://support.webgk.ru/?ID=#ID#&edit=1">##ID#</a>: необходимо вернуться к работе;<br>';
		$filtered_tickets = array_filter($tickets, [$this, 'filterTickets']);
		if (!empty($filtered_tickets)) {
			$this->addCaseMessages($case_message_template, $filtered_tickets);
			$this->success_flag = true;
		}
	}
	
	/**
	 * 
	 * Запуск всех кейсов связанных со статусами.
	 * 
	 * @param int $user_id
	 * 
	 * */
	public function runPersonalNotifications($personal_id) {
		if (is_array($this->support_users) && is_array($this->support_users[$personal_id]) && !in_array($personal_id, $this->support_admin_ids)) {
			if ($tickets = $this->getUsersTickets($personal_id)) {
				$this->checkFirstCase($tickets);
				$this->checkSecondCase($tickets);
				$this->checkThirdCase($tickets);
				// если есть что отправлять - отправляем
				if ($this->success_flag) {
					$this->sendNotify($personal_id, $this->support_users[$personal_id]['NAME'], true);
				}
			}
		} else if (in_array($personal_id, $this->support_admin_ids) && is_array($this->support_users)) {
			foreach ($this->support_users as $user_id => $user) {
				if ($tickets = $this->getUsersTickets($user_id)) {
					$this->message = "Тикеты, требующие внимания:<br>";
					$this->success_flag = false;
					$this->checkFirstCase($tickets);
					$this->checkSecondCase($tickets);
					$this->checkFifthCase($tickets);
					// если есть что отправлять - отправляем
					if ($this->success_flag) {
						$this->sendNotify(0, $user['NAME'], false, $personal_id);
					}
				} else {
					continue;
				}
			}
			$this->sendEmailNotify($personal_id);
		}
	}
	
	/**
	 * 
	 * Запуск всех кейсов связанных со статусами.
	 * 
	 * */
	public function runStatusCases() {
		if (is_array($this->support_users)) {
			foreach ($this->support_users as $user_id => $user) {
				if ($tickets = $this->getUsersTickets($user_id)) {
					$this->message = "Тикеты, требующие внимания:<br>";
					$this->success_flag = false;
					$this->checkFirstCase($tickets);
					$this->checkSecondCase($tickets);
					$this->checkThirdCase($tickets);
					$this->checkFifthCase($tickets);
					$this->checkSixthCase($tickets);
					$this->checkSeventhCase($tickets);
					// если есть что отправлять - отправляем
					if ($this->success_flag) {
						$this->sendNotify($user_id, $user['NAME']);
					}
				} else {
					continue;
				}
			}
			// Если есть что отсылать админам на email - отсылаем
			if ($this->admin_message) {
				foreach ($this->support_admin_ids as $admin_id) {
					$this->sendEmailNotify($admin_id);
				}
			}
		}
	}
	
	/**
	 * 
	 * Запуск админских кейсов.
	 * 
	 * */
	public function runAdminOnlyCases() {
		if (is_array($this->support_admin_ids)) {
			$this->message = "Тикеты, требующие внимания:<br>";
			$this->success_flag = false;
			$this->checkFourthCase();
			if ($this->success_flag) {
				$this->sendNotify(0, iconv('utf-8', 'windows-1251', "неназначенные тикеты"));
				foreach ($this->support_admin_ids as $admin_id) {
					$this->sendEmailNotify($admin_id);
				}
			}
		}
	}
	
	/**
	 * 
	 * Фильтр для тикетов. Используется в array_filter
	 * 
	 * @param array $ticket
	 * @return bool
	 * 
	 * */
	public function filterTickets($ticket) {
		switch ($this->current_test_case) {
			case 1:
				$time_diff = time() - $this->timestampConverter($ticket['LAST_MESSAGE_DATE']);
				return $ticket['STATUS'] == self::NEEDS_CLIENT_DECISION && !in_array($ticket['LAST_MESSAGE_OWNER'], array_keys($this->support_users)) && $time_diff >= self::FOUR_HOURS;
			
			case 2:
				$time_diff = time() - $this->timestampConverter($ticket['LAST_MESSAGE_DATE']);
				return $ticket['STATUS'] == self::NEEDS_CLIENT_DECISION && in_array($ticket['LAST_MESSAGE_OWNER'], array_keys($this->support_users)) && $time_diff >= self::THREE_DAYS;
				
			case 3:
				$time_diff = time() - $this->timestampConverter($ticket['LAST_MESSAGE_DATE']);
				return $ticket['STATUS'] == self::SOLVED && !in_array($ticket['LAST_MESSAGE_OWNER'], array_keys($this->support_users)) && $time_diff >= self::FOUR_HOURS;
			
			case 5:
				$time_diff = time() - $this->timestampConverter($ticket['LAST_MESSAGE_DATE']);
				return ($ticket['STATUS'] == self::ACCEPTED || $ticket['STATUS'] == self::NEW_TICKET) && !in_array($ticket['LAST_MESSAGE_OWNER'], array_keys($this->support_users)) && $time_diff >= self::ONE_DAY;
				
			case 6:
				$time_diff = time() - $this->timestampConverter($ticket['LAST_MESSAGE_DATE']);
				return $ticket['STATUS'] == self::THIRD_PARTY_SUPPORT && ((!in_array($ticket['LAST_MESSAGE_OWNER'], array_keys($this->support_users)) && $time_diff >= self::ONE_DAY) || (in_array($ticket['LAST_MESSAGE_OWNER'], array_keys($this->support_users)) && $time_diff >= self::TWO_DAYS));
				
			case 7:
				$time_diff = $ticket['LAST_TRANSACTION_DATE'] ? time() - $this->timestampConverter($ticket['LAST_TRANSACTION_DATE']) : "";
				return $ticket['STATUS'] == self::IN_PROGRESS && (!$ticket['LAST_TRANSACTION_DATE'] || $time_diff >= self::TWO_DAYS);
		}
	}
	
	/**
	 * 
	 * Добавить в результирующий массив сообщения по выбранному кейсу.
	 * 
	 * @param string $template - шаблон фразы с макросами
	 * @param array $tickets - массив отфильтрованных тикетов
	 * @return void 
	 * 
	 * */
	
	private function addCaseMessages($template, $tickets) {
		foreach ($tickets as $ticket) {
			$this->message .= str_replace("#ID#", $ticket['ID'], $template);
		}
	}
	
	/**
	 * 
	 * Получить список тикетов для сотрудника
	 * 
	 * @param int $responsible_id
	 * @return array $result
	 * 
	 * */
	private function getUsersTickets($responsible_id) {
		if ($responsible_id) {
			$result = [];
			$filter = [
				"RESPONSIBLE_ID" => $responsible_id,
				"CLOSE"          => "N",
			];
			
			$tickets = CTicket::GetList($by = "s_id", $order = "asc", $filter, $is_filtered, "N", "N", "Y");
			
			while ($ticket = $tickets->Fetch()) {
				$result[$ticket['ID']] = [
					"ID"                 => $ticket['ID'],
					"LAST_MESSAGE_DATE"  => $ticket['LAST_MESSAGE_DATE'],
					"LAST_MESSAGE_OWNER" => $ticket['LAST_MESSAGE_USER_ID'],
					"STATUS"             => $ticket['STATUS_ID']
				]; 
			}

			if (!empty($result)) {
				$this->getLastBillingTransactionsForTickets($result);
			}
			
			return $result;
		}
	}
	
	/**
	 * 
	 * Рассылаем уведомления ответственным и администаторам
	 * 
	 * @param int $responsible_id
	 * @param string $responsible_name
	 * @param bool $user_only
	 * @param int $concrete_admin_id
	 * @return void
	 * 
	 **/
	private function sendNotify($responsible_id, $responsible_name, $user_only = false, $concrete_admin_id) {
		// отправляем информацию по тикетам администаторам
		if (!$user_only) {
			foreach ($this->support_admin_ids as $admin_id) {
				if ($concrete_admin_id && $concrete_admin_id != $admin_id) {
					continue;
				}
				if ($admin_id != $responsible_id) {
					CPullStack::AddByUser($admin_id, [
						'module_id' => 'deskman',
						'command'   => 'check',
						'params'    => [
							'data' => json_encode([
								'header'  => 'Уведомления по задачам - ' . iconv('windows-1251', 'utf-8', $responsible_name), // все сообщения должны быть только в UTF8, иначе в js придет null
								'message' => $this->message,
							])
						],
					]);
				}
			}
		}
		$this->admin_message .= 'Уведомления по задачам - <b>' . iconv('windows-1251', 'utf-8', $responsible_name) . "</b><br>" . $this->message . "<br>";

		if ($responsible_id) {
			// теперь просто отправляем сообщение самому ответственному
			CPullStack::AddByUser($responsible_id, [
				'module_id' => 'deskman',
				'command'   => 'check',
				'params'    => [
					'data' => json_encode([
						'header'  => 'Уведомления по моим задачам', // все сообщения должны быть только в UTF8, иначе в js придет null
						'message' => $this->message,
					])
				],
			]);
			// отправляем email не админам, т.е. персональное сообщение
			if (!in_array($responsible_id, $this->support_admin_ids)) {
				$message = 'Уведомления по моим задачам' . "<br>" . $this->message;
				$this->sendEmailNotify($responsible_id, $message);
			}
		}
	}
	
	
	/**
	 * 
	 * Отсылаем сообщения на email
	 * 
	 * @param int $responsible_id
	 * @return void
	 * 
	 * */
	private function sendEmailNotify($responsible_id, $message = "") {
		// если сообщение задано, то это персональное уведомление
		// если нет, то это сводное сообщение для админов, оно хранится в $this->admin_message
		$message = $message ? $message : $this->admin_message;
		$email_fields = [
        	"EMAIL_TO" => $this->support_users[$responsible_id]['EMAIL'],
			"MESSAGE"  => iconv('utf-8', 'windows-1251', $message)
        ];
        CEvent::Send(self::EMAIL_EVENT_TYPE, "s1", $email_fields, 'Y', self::EMAIL_TEMPLATE_ID);
	}
	
	/**
	 * Конвертируем дату в unix timestamp
	 * 
	 * @param string $date - пример 15.01.2016 11:10:26
	 * @return int $time
	 * */
	private function timestampConverter($date) {
		$date_time = DateTime::createFromFormat("d.m.Y H:i:s", $date);
		$time = $date_time->getTimestamp();
		return $time;
	}
	
	/**
	 * Получим последние записи биллинга для тикетов
	 * 
	 * @param array $tickets
	 * @return void
	 * */
	private function getLastBillingTransactionsForTickets(&$tickets) {
		CModule::IncludeModule('webgk.support');
		$transactions = GKSupportSpentTime::GetLastTransactionsForTickets(array_keys($tickets));
		while ($transaction = $transactions->Fetch()) {
			if (array_key_exists($transaction['TICKET_ID'], $tickets)) {
				$base_format = DateTime::createFromFormat('Y-m-d H:i:s', $transaction['DATE']);
				$site_format = $base_format->format('d.m.Y H:i:s');
				$tickets[$transaction['TICKET_ID']]['LAST_TRANSACTION_DATE'] = $site_format;
			}
		}
	}
	
}
?>