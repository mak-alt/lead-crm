<?php

namespace App\Traits;

use App\Models\User;

trait Role {

	public function superAdmin()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::SUPER_ADMIN, $roles)) {
            return true;
        }
        return false;
	}

	public function partner()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::PARTNER, $roles)) {
            return true;
        }
        return false;
	}

	public function salesHead()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::SALES_HEAD, $roles)) {
            return true;
        }
        return false;
	}

	public function sales()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::SALES, $roles)) {
            return true;
        }
        return false;
	}

	public function productionHead()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::PROD_HEAD, $roles)) {
            return true;
        }
        return false;
	}

	public function production()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::PROD, $roles)) {
            return true;
        }
        return false;
	}

	public function client()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
        if (in_array(User::CLIENT, $roles)) {
            return true;
        }
        return false;
	}

	public function isRole()
	{
		$roles = auth()->user()->roles->pluck('slug')->toArray();
		return $roles[0] ?? null;
	}

}