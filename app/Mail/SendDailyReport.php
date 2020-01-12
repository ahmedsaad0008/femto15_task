<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDailyReport extends Mailable {
	use Queueable, SerializesModels;

	private $number;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($number) {
		$this->number = $number;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$num = $this->number;
		return $this->view('emails.report', compact('num'));
	}
}
