<?php
namespace App\Database\Seeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder 
{
    public $token;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->token ='9SCbMO9bCFKQbrYSXhICIX4R86hsGb3s';
	}
    
    
    private function getForder($id) {
        $server = 'https://api.box.com/2.0/folders/'.$id; 
        $ch = curl_init($server);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization:Bearer ".$this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {   
            curl_close($ch);
            return json_decode($data);
        }
    }
    
    
    private function getFileContent($id) {
        $server = 'https://api.box.com/2.0/files/'.$id.'/content';        
        $ch = curl_init($server);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization:Bearer ".$this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
           
        $content = curl_exec($ch);
        
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
           curl_close($ch);
           return $content; 
        }
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::truncate();
    }
}
