<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$admins = [
			[
				'name' => 'ahmed',
				'email' => 'test@admin.com',
				'password' => '123456789',
			],
			[
				'name' => 'ahmed',
				'email' => 'test2@admin.com',
				'password' => '123456789',
			],
		];
		foreach ($admins as $admin) {
			DB::table('admins')->insert([
				'name' => $admin['name'],
				'email' => $admin['email'],
				'password' => Hash::make($admin['password']),
			]);
		}
	}
}
