<?php namespace App\Http\Controllers;

use App\Models\Order;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
    public $token;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
	   Order::truncate();
	   //START Folder 0
       
        $param = $this->getForder('8463480137');
        //echo '<pre>'; print_r($param); echo '</pre>';
        //exit(); 
                     
        if (isset($param->{'item_collection'})) {
            foreach ($param->{'item_collection'}->{'entries'} as $folder) {
                if ($folder->{'type'} == 'folder') {
                    // Curl Get Data Folder/FolderId
                    $paramFolder = $this->getForder($folder->{'id'}); 
                    
                    
                    foreach ($paramFolder->{'item_collection'}->{'entries'} as $file) {
                        echo $folder->{'name'}.'<br>';
                        if ($file->{'type'} == 'file') {
                            // Curl Get Data Folder/FolderId
                            $content = $this->getFileContent($file->{'id'});
                            
                            $order = $file->{'name'};
                            if (strpos($content, 'Driver:')) {
                                $driver_start = substr($content, strpos($content, 'Driver:'));
                                
                                $driver = substr($driver_start, 0, strpos($driver_start, '.'));
                                
                                $client_start = substr($content, strpos($content, 'Customer Name:'));
                                $client = substr($client_start, 0, strpos($client_start, 'Incase of any query'));
                                Order::Create([
                                'order' => $order,
                                'driver' => $driver,
                                'client' => $client
                                
                                ]);
                               // echo $order.'<br>'; 
                               // echo $driver.'<br>';
                               // echo $client.'<br>';
                            }
                        }
                             
                    }
                    exit(); 
                }
                     
            }
        }         
       
        
       
       
       
       
       
       
       
       
       
	   // link for start authorization
       
      // echo '<a href="https://account.box.com/api/oauth2/authorize?response_type=code&client_id=zoaa7gvb12kkm45ela5evc9rsl82sb12&state=security_token%3DKnhMJatFipTAnM0nHlZA">Box</a>';

       // Curl for TOKEN ACCESS
      // if (isset($_GET['code'])) {
            
/**
 *             $server = 'https://api.box.com/oauth2/token';
 *             $request = http_build_query([
 *                 'grant_type'=> 'authorization_code',
 *                 'code' => $_GET['code'],
 *                 'client_id' => 'zoaa7gvb12kkm45ela5evc9rsl82sb12',
 *                 'client_secret' => 'kcNWv2M0SkiIAySCyBk7cAW5DLRmhtNB'
 *             ]);
 *             echo '<br>'.$request.'<br>';
 *         $ch = curl_init();
 *         curl_setopt($ch, CURLOPT_URL, $server);
 *         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);           
 *         curl_setopt( $ch, CURLOPT_POST, TRUE);
 *         curl_setopt( $ch, CURLOPT_POSTFIELDS, $request);
 *         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 *         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 *         
 *         $data = curl_exec($ch);

 *         if (curl_errno($ch)) {
 *             print "Error: " . curl_error($ch);
 *         } else {            
 *             $param = json_decode($data);
 *             if (isset($param->{'access_token'})) $token = $param->{'access_token'};            
 *         }  
 *         curl_close($ch);
 *         
 *         
 */
        
          
            
        
        
        
        
        
       
        
        
        
        
        
        
        $server = 'https://api.box.com/2.0/files/72651349957/content';        
        $ch = curl_init($server);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization:Bearer ".$token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
           
         $content = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            // Show me the result
            /**
 * $param = json_decode($data);
 *             echo '<pre>'; print_r($param); echo '</pre>';
 */
            
          //  var_dump($data);
          
          $driver_start = substr($content, strpos($content, 'Driver:'));
                            $driver = substr($driver_start, 0, strpos($driver_start, '.'));
                            
                            $client_start = substr($content, strpos($content, 'Customer Name:'));
                            $client = substr($client_start, 0, strpos($client_start, 'Incase of any query'));
                            
                          //  echo $order.'<br>'; 
                            echo $driver.'<br>';
                            echo $client.'<br>';
            
            
            #$url = $param->{'shared_link'}->{'download_url'};
            
            #$content = file_get_contents($url);
          //  echo $url;
            #echo $content;
            curl_close($ch);
        }    
    /**
 *    
 *        
 *        $server = 'https://api.box.com/2.0/files/72651349957/content';
 *        
 *        $request = json_encode([
 *             'name'=> 'CRN18484595.html',
 *             'parent' => [
 *                 'id' => '8682147025'
 *             
 *             ]
 *         ]);
 *         $ch = curl_init();
 *       // curl_setopt($ch, CURLOPT_HTTPHEADER,array("Expect:  "));
 *         curl_setopt($ch, CURLOPT_URL, $server);
 *         curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authorization:Bearer ".$token));
 *         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 *         curl_setopt( $ch, CURLOPT_POST, TRUE);
 *         curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query(['attributes'=>$request, 'file'=>'@myfile.html']));
 *         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 *         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 *         
 *            
 *         $data = curl_exec($ch);
 * //echo $request;
 *         if (curl_errno($ch)) {
 *             print "Error: " . curl_error($ch);
 *         } else {
 *             // Show me the result
 *             
 *             $param = json_decode($data);
 *             var_dump($data);
 *             echo '<pre>'; print_r($param); echo '</pre>';
 *            
 *            
 *             curl_close($ch);
 *        
 *        
 *        }
 *        
 *        
 */
       
       
       
       
            
        
        
     

       
       
       
       
       
       
   //    }
       
       
       
    //   exit();
       
       /*
        $dir = "http://test1/driver/";
        $file = 'CRN72584891.html';
        $content = file_get_contents($dir.$file);

 echo $content;
        if (is_dir($dir)) { 
            if ($handle  = opendir($dir)) {
              
                while (($file = readdir($handle)) !== false) {
                   
                    if (is_file($dir.$file)) {
                        if (fopen($dir.$file, 'r')) {      
                            $content = file_get_contents($dir.$file);
                
              //  echo '<pre>'; print_r(basename(__DIR__."/driver/CRN18484595.html")); echo '</pre>'; 
              
              
             //   $order_start = substr($file, strpos($file, 'Your order '));
                            $order = basename($file);
                            
                            $driver_start = substr($content, strpos($content, 'Driver:'));
                            $driver = substr($driver_start, 0, strpos($driver_start, '.'));
                            
                            $client_start = substr($content, strpos($content, 'Customer Name:'));
                            $client = substr($client_start, 0, strpos($client_start, 'Incase of any query'));
                            
                            echo $order.'<br>'; 
                            echo $driver.'<br>';
                            echo $client.'<br>';
                        }
                    }
                }
                closedir($handle);
            }
        }
       

       
       */
        
        exit();
            
        
        
        
        
		return view('welcome');
        
        
	}

}
