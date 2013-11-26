<?php

/*
	Socialcast Notifications

	File: qa-plugin/qa-socialcast-notifications/qa-socialcast-notifications-event.php
	Version: 0.1
	Date: 2013-11-26
	Description: Event module class for Socialcast notifications plugin
*/


class qa_socialcast_notifications_event {

	private $socialcast = array(
		'username' => '',
		'password' => '',
		'url' => 'https://demo.socialcast.com/api/messages.json',
	);

	// keep empty if no proxy required
	private $proxy = '';

	public function process_event($event, $userid, $handle, $cookieid, $params) {
		require_once QA_INCLUDE_DIR . 'qa-app-emails.php';
		require_once QA_INCLUDE_DIR . 'qa-app-format.php';
		require_once QA_INCLUDE_DIR . 'qa-util-string.php';

		switch ($event) {
			case 'q_post':
				$this->send_socialcast_notification(
					$this->build_socialcast_request(
						isset($handle) ? $handle : qa_lang('main/anonymous'),
						$params['title'],
						$params['text'],
						qa_q_path($params['postid'], $params['title'], true)
					)
				);
		}
	}

	public function build_socialcast_request($who, $title, $content, $url) {
		return array(
			'message[body]' => sprintf("%s asked a new question \"%s\" on #QNA, check it out!", $who, $title),
			'message[url]' => $url,
		);
	}

	private function send_socialcast_notification(array $request) {
		$ch = curl_init();

		// uncomment this if you have SSL verification problem
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		if ($this->proxy) {
			curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		}

		curl_setopt($ch, CURLOPT_USERPWD, $this->socialcast['username'] . ":" . $this->socialcast['password']);

		curl_setopt($ch,CURLOPT_URL, $this->socialcast['url']);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($request));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		echo $result;

		curl_close($ch);
	}
}
