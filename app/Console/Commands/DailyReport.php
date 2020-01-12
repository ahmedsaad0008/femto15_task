<?php

namespace App\Console\Commands;

use App\Mail\SendDailyReport;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class DailyReport extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'daily:report';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'send number of user register every day';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$today = Carbon::now()->toDateString();
		$num = User::whereDate('created_at', $today)->count();
		Mail::to("asaad0008@gmail.com")->send(new SendDailyReport($num));
	}
}
