<?php
use PubNub\PubNub;
use PubNub\Enums\PNStatusCategory;
use PubNub\Callbacks\SubscribeCallback;
use PubNub\PNConfiguration;

class Lib_Pubnub
{
	private $_pub_key = "pub-c-8ab790df-cd80-4e67-9302-49e09cd48217";
	private $_sub_key = "sub-c-ee0cf98c-8bc8-11e7-99f6-f65693608d5b";
	private $_secret_key = "sec-c-MDcwOTc5ODctMzk0MC00NTc4LWFhNmYtMDBmYTZjZDg3MjVh";
	private $_pubnub = NULL;
	private $_channel = "friday_web";

	public function __construct() {
		$pnconf = new PNConfiguration();
		$pnconf->setSubscribeKey($this->_sub_key);
		$pnconf->setPublishKey($this->_pub_key);
		$pnconf->setSecretKey($this->_secret_key);
		$pnconf->setSecure(false);

		$this->_pubnub = new PubNub($pnconf);
	}

	public function send_message($data) {
		return $this->_pubnub->publish()
					->channel($this->_channel)
					->message($data)
					->sync();
	}
}
