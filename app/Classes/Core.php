<?php

namespace App\Classes;

use App\Classes\Helper;
use Illuminate\Support\Facades\File;
use App\Traits\Role;

/**
 * Main and Core helper class
 */
class Core
{
	use Role;

	protected $media_path;

	function __construct()
	{
		// code...
	}

	// upload new media related to leads
	public function uploadMedia($file = null, $folder = null)
	{
		if(!$file && !$folder){
			return false; 
		}

		return $this->saveMedia($folder,$file);
	}


	protected function saveMedia($folder, $file)
	{	
		$original_name = time().'-'.$file->getClientOriginalName();
		return $file->move($this->generateMediaPath($folder,$file),$original_name);
	}


	protected function generateMediaPath($folder,$file)
	{	
		$path = public_path().'/contents/'.$folder.'/'.$this->currentWebsite()->domain.'/'.$file->created_at->format('Y-m-d');
		if(!File::exists($path)){
			return $this->media_path = File::makeDirectory($path, 0777, true); //creates directory
		}

		return $this->media_path = $path;
	}
	/**
	 * make date formatted
	 * @param  Carbon $date 
	 * @param  string $format
	 * @return Carbon $date 
	 */
	public function formatDate($date = null, $format = 'd-m-Y H:i:s'){

	    if (is_null($date)) {
	        $date = Carbon::now();
	    }

	    return $date->format($format);
	}

	public function readableDate($date = null){
		if (is_null($date)) {
        	$date = Carbon::now();
    	}
		return $date->diffForHumans();
	}

	//set session
	public function setSession($arr = []){
		return session()->put($arr);
	}

	//get session
	public function getSession($key){
		return session()->get($key);
	}

	//get current website
	public function currentWebsite() {
		return $this->getSession('website_session');
	}

	//set timezone on run time
	public function changeTimezone($timezone) {
		return config(['app.timezone' => $timezone]);
	}

	public function resetTimezone($timezone) {
		return config(['app.timezone' => 'Asia/Karachi']);
	}

}