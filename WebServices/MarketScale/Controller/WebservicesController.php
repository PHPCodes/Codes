<?php
	#Project : CrowdCareer
	App::uses('AppController', 'Controller');
	class WebservicesController extends AppController {
		public $components = array('ImageResize');
		public function beforeFilter() 
		{
			parent::beforeFilter();
			$this->Auth->allow(array('student_signup','employer_signup','login','forgot','admin_reset','changepass','myProfile','profile_edit','topics','companies_list','calculator','user','student_list','student_followers','employer_follower','student_unfollow','employer_unfollow','company_connection_student','company_connection_company','company_profile','people_you_may_know','student_connection_company','student_connection_student','post_jobs','employe_profile','jobs','apply_job','student_profile'));
			$this->loadModel('User');
		}
		
		/*	1 API  ( student_signup ) *///http://dev414.trigma.us/Crowd-Career/Webservices/student_signup?display_name=gurudutt1&image=profileimage2.png&email=gurudutt.sharma@trigma.in&college=abc&register_type=manual&password=123456&contact=123
		public function student_signup () 
		{
			//pr ($_REQUEST);
			$this->loadModel('User');
			$data['User']['username']		=	@$_REQUEST['display_name'];  
			$data['User']['profile_image']  	=  @$_REQUEST['image'];	
			$data['User']['email'] 				=  @$_REQUEST['email'];  
			$data['User']['contact']  			=  @$_REQUEST['contact'];			
			$data['User']['college']  			=  @$_REQUEST['college'];			
			$data['User']['register_type']  	=  @$_REQUEST['register_type'];			
			$data['User']['status'] 				=	1;
			$data['User']['register_date'] 	= 	date("Y-m-d"); 
			$data['User']['usertype_id']  	=  7;
		
			if ($_REQUEST['register_type']	==	"facebook") 
			{	
				$data['User']['fb_id']  			=  @$_REQUEST['fb_id'];		
				$data['User']['registertype'] 	=  @$_REQUEST['register_type'];	
				if(isset($_REQUEST['display_name'])) 
				{
					$data['User']['username']= $_REQUEST['display_name'];
				} else {
					$data['User']['username']= '';
				}
				if(isset($_REQUEST['image'])) {
					$data['User']['profile_image']	= $_REQUEST['image'];
				} else {
					$data['User']['profile_image']	= '';
				} 
				if(isset($_REQUEST['email'])) {
					$data['User']['email']		= $_REQUEST['email'];
				} else {
					$data['User']['email']		= '';
				} 
				if(isset($_REQUEST['contact']) && !empty($_REQUEST['contact'])) {
					$data['User']['contact']	= $_REQUEST['contact'];
				} else {
					$data['User']['contact']	= '';
				} 
				if(isset($_REQUEST['college'])) {
					$data['User']['college']		= $_REQUEST['college'];
				} else {
					$data['User']['college']		= '';
				} 					
				$getFbIDStatus 					=  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
				if (empty($getFbIDStatus))
				 {
					$fbexist 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.fb_id'=>$_REQUEST['fb_id']))));
					if (empty($fbexist)) 
					{
						
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  				= 	$this->User->getLastInsertID();
							$this->User->query("update users set password= '' where id = '".$user_id."'");
							$response 			= 	array('status'=>1,'message'=>'Student Register Successfully with facebook','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						} 
						else 
						{
							$response				= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}
					else
					{
						$response					= 	array('status'=>3,'message'=>'Facebook id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 			
				}
				else {
					$response 					= 	array('status'=>3,'message'=>'facebook id  already exist, please try another user');
					echo json_encode($response);
					exit;		    
				}
			}
			elseif($_REQUEST['register_type']	==	"linkedin") {
				$data['User']['linkedin_id']  				=  $_REQUEST['linkedin_id'];
				if(isset($_REQUEST['display_name'])) 
				{
					$data['User']['username']	= $_REQUEST['display_name'];
				} else {
					$data['User']['username']	= '';
				}
				if(isset($_REQUEST['image'])) {
					$data['User']['profile_image']	= $_REQUEST['image'];
				} else {
					$data['User']['profile_image']	= '';
				} 
				if(isset($_REQUEST['email'])) {
					$data['User']['email']			= $_REQUEST['email'];
				} else {
					$data['User']['email']			= '';
				} 
				if(isset($_REQUEST['contact']) && !empty($_REQUEST['contact'])) {
					$data['User']['contact']		= $_REQUEST['contact'];
				} else {
					$data['User']['contact']		= '';
				} 
				if(isset($_REQUEST['college'])) {
					$data['User']['college']	= $_REQUEST['college'];
				} else {
					$data['User']['college']	= '';
				} 				
				$getlnIDStatus 							=  $this->User->find('first',array('conditions'=>array('User.linkedin_id'=>$_REQUEST['linkedin_id'])));
				if (empty($getlnIDStatus))
				{
					$twitexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.linkedin_id'=>$_REQUEST['linkedin_id']))));
					if (empty($twitexist)) 
					{
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  						= 	$this->User->getLastInsertID();
							$this->User->query("update users set password= '' where id = '".$user_id."'");
							$response 					= 	array('status'=>1,'message'=>'Student Register Successfully with LinkedIN','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						} 
						else 
						{
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}
					else
					{
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 				
				} 
				else 
				{
						$response 					= 	array('status'=>3,'message'=>'linked in already exist, please try another user');
						echo json_encode($response);
						exit;		    
				}
			}
			else if($_REQUEST['register_type']== "manual") {
				//echo "dd";
				//echo "kkk";die;
				$data['User']['password']  		=  @$_REQUEST['password'];
				$exist 									= 	$this->User->find("first", array("conditions" => array("User.username" => $data['User']['username'])));

				if (empty($exist))  {
					$emailexist 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
					if (empty($emailexist))  {
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id    				=  $this->User->getLastInsertID();							
							if(@$_REQUEST['image']!='') {  
								$name					=  $user_id."profileImage.png";
								$this->User->saveField('profile_image',$name);
								@$_REQUEST['profile_image']	=  str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
								$_REQUEST['profile_image'] 		=  str_replace(' ', '+',$_REQUEST['profile_image']);
								$unencodedData						=  base64_decode($_REQUEST['profile_image']);
								$pth 											=  WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
								file_put_contents($pth, $unencodedData);
							 }
							 $isf	 						= 	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
							if(isset($isf['User']['id'])) {
								$user_id	=	$isf['User']['id'];
							} else {
								$user_id	=	'';
							}
							if(isset($isf['User']['usertype_id'])) {
								$usertype_id	=	$isf['User']['usertype_id'];
							} else {
								$usertype_id	=	'';
							}
							if(isset($isf['User']['email'])) {
								$email	=	$isf['User']['email'];
							} else {
								$email	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['username'])) {
								$username	=	$isf['User']['username'];
							} else {
								$username	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['college'])) {
								$college	=	$isf['User']['college'];
							} else {
								$college	=	'';
							}
							$response = array (
								'status' 			=> 1,
								'message'		=> 'Student Register Successfully',
								'user_id' 		=> $user_id,
								'username'	=> $username,
								'college' 		=> $college,
								'image'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'],
								'email'			=> $email,
								'contact'		=> $contact,
								'usertype_id'	=> $usertype_id							
							);
							echo json_encode($response);die;
							exit;
						} 
						else 
						{
							$response						= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}
					else
					{
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 					
				}
				else 
				{
					$response 							= 	array('status'=>3,'message'=>'Student already exist, please try another user');
					echo json_encode($response);
					exit;		    
				}		
			}
			exit;			
		}
		
		/*	2 API ( employer_signup )	*/// http://dev414.trigma.us/Crowd-Career/Webservices/employer_signup?company_name=trigma&image=profileimage3.png&email=guru123.sharma@trigma.in&register_type=manual&password=123456&contact=1234543554&category_id=2&description=ghghghg
		public function employer_signup () 
		{
			//pr ($_REQUEST);
			$this->loadModel('User');
			$data['User']['company_name']	=	@$_REQUEST['company_name'];  
			$data['User']['profile_image']  		=  @$_REQUEST['image'];
			$data['User']['email'] 					=  @$_REQUEST['email'];  
			$data['User']['category_id']  		=  @$_REQUEST['category_id'];			
			$data['User']['description']  			=  @$_REQUEST['description'];			
			$data['User']['register_type']  		=  @$_REQUEST['register_type'];			
			$data['User']['contact']  				=  @$_REQUEST['contact'];			
			$data['User']['status'] 					=	1;
			$data['User']['register_date'] 		= 	date("Y-m-d"); 
			$data['User']['usertype_id']  		=  8;		
			if ($_REQUEST['register_type']	==	"facebook") 
			{	
				$data['User']['fb_id']  				=  @$_REQUEST['fb_id'];		
				$data['User']['registertype']  	=  @$_REQUEST['register_type'];	
			
				if(isset($_REQUEST['company_name'])) 
				{
					$data['User']['company_name']	= $_REQUEST['company_name'];
				} else {
					$data['User']['company_name']	= '';
				}
				if(isset($_REQUEST['image'])) {
					$data['User']['profile_image']	= $_REQUEST['image'];
				} else {
					$data['User']['profile_image']	= '';
				} 
				if(isset($_REQUEST['email'])) {
					$data['User']['email']			= $_REQUEST['email'];
				} else {
					$data['User']['email']			= '';
				} 
				if(isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
					$data['User']['category_id']		= $_REQUEST['category_id'];
				} else {
					$data['User']['category_id']		= '';
				} 
				if(isset($_REQUEST['description'])) {
					$data['User']['description']	= $_REQUEST['description'];
				} else {
					$data['User']['description']	= '';
				} 					
				$getFbIDStatus 						=  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
				if (empty($getFbIDStatus))
				{
					$fbexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.fb_id'=>$_REQUEST['fb_id']))));
					if (empty($fbexist)) 
					{
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  					= 	$this->User->getLastInsertID();
							$this->User->query("update users set password= '' where id = '".$user_id."'");
							$response 				= 	array('status'=>1,'message'=>'User Register Successfully with facebook','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						} 
						else 
						{
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}
					else
					{
						$response						= 	array('status'=>3,'message'=>'Facebook id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 			
				}
				else {
					$response 						= 	array('status'=>3,'message'=>'facebook id  already exist, please try another user');
					echo json_encode($response);
					exit;		    
				}
			}
			elseif($_REQUEST['register_type']	==	"linkedin") {
				$data['User']['linkedin_id']  			=  $_REQUEST['linkedin_id'];
				$data['User']['user_type']  			=  8;
				if(isset($_REQUEST['company_name'])) 
				{
					$data['User']['company_name']	= $_REQUEST['company_name'];
				} else {
					$data['User']['company_name']	= '';
				}
				if(isset($_REQUEST['image'])) {
					$data['User']['profile_image']	= $_REQUEST['image'];
				} else {
					$data['User']['profile_image']	= '';
				} 
				if(isset($_REQUEST['email'])) {
					$data['User']['email']			= $_REQUEST['email'];
				} else {
					$data['User']['email']			= '';
				} 
				if(isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
					$data['User']['category_id']		= $_REQUEST['category_id'];
				} else {
					$data['User']['category_id']		= '';
				} 
				if(isset($_REQUEST['description'])) {
					$data['User']['description']	= $_REQUEST['description'];
				} else {
					$data['User']['description']	= '';
				} 				
				$getlnIDStatus 							=  $this->User->find('first',array('conditions'=>array('User.linkedin_id'=>$_REQUEST['linkedin_id'])));
				if (empty($getlnIDStatus))
				{
					$twitexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.linkedin_id'=>$_REQUEST['linkedin_id']))));
					if (empty($twitexist)) 
					{
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  						= 	$this->User->getLastInsertID();
							$this->User->query("update users set password= '' where id = '".$user_id."'");
							$response 					= 	array('status'=>1,'message'=>'Employer Register Successfully with LinkedIn','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						} 
						else 
						{
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}
					else
					{
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 				
				} 
				else 
				{
						$response 					= 	array('status'=>3,'message'=>'linked in already exist, please try another user');
						echo json_encode($response);
						exit;		    
				}
			}
			else if($_REQUEST['register_type']== "manual") {
				//echo "dd";
				//echo "kkk";die;
				$data['User']['password']  		=  @$_REQUEST['password'];
				$exist 									= 	$this->User->find("first", array("conditions" => array("User.company_name" => $data['User']['company_name'])));

				if (empty($exist))
				{
					$emailexist 							= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
					if (empty($emailexist)) 
					{
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id    						= $this->User->getLastInsertID();							
							if(@$_REQUEST['image']!='')  {  
								$name										=  $user_id."profileImage.png";
								$this->User->saveField('profile_image',$name);
								@$_REQUEST['profile_image']	=  str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
								$_REQUEST['profile_image'] 		=  str_replace(' ', '+',$_REQUEST['profile_image']);
								$unencodedData						=  base64_decode($_REQUEST['profile_image']);
								$pth 											=  WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
								file_put_contents($pth, $unencodedData);
							 }
							$isf 									= $this->User->find("first", array("conditions" =>array("User.id" => $user_id)));
							if(isset($isf['User']['id'])) {
								$user_id	=	$isf['User']['id'];
							} else {
								$user_id	=	'';
							}
							if(isset($isf['User']['usertype_id'])) {
								$usertype_id	=	$isf['User']['usertype_id'];
							} else {
								$usertype_id	=	'';
							}
							if(isset($isf['User']['email'])) {
								$email	=	$isf['User']['email'];
							} else {
								$email	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['company_name'])) {
								$company_name	=	$isf['User']['company_name'];
							} else {
								$company_name	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['category_id'])) {
								$category_id	=	$isf['User']['category_id'];
							} else {
								$category_id	=	'';
							}
							if(isset($isf['User']['description'])) {
								$description	=	$isf['User']['description'];
							} else {
								$description	=	'';
							}
							$response = array (
								'status' => 1,
								'message'=> 'Employer Register Successfully',
								'user_id' => $user_id,
								'company_name' => $company_name,
								'image'=>FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'],
								'email'=>$email,
								'contact'=>$contact,
								'category_id'=>$category_id,
								'description'=>$contact,
								'usertype_id' =>$usertype_id							
							);
							echo json_encode($response);die;
							exit;
						} 
						else 
						{
							$response						= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}
					else
					{
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 					
				}
				else 
				{
					$response 							= 	array('status'=>3,'message'=>'User already exist, please try another user');
					echo json_encode($response);
					exit;		    
				}		
			}
			exit;			
		}
		
		/* 3 API Login */
		// http://dev414.trigma.us/Crowd-Career/Webservices/login?email=gurudutt.sharma@trigma.in&password=123456
	 
		public function login ($u = null,$p = null)	
		{
			$this->request->data['User']['username']	=	$_REQUEST['email'];
			$this->request->data['User']['password']	= 	$_REQUEST['password'];                 
			$usern 													= 	$this->request->data['User']['username'];
			$us 														= 	$this->User->find("first", array("conditions" => array("User.email" => $usern)));
			if	(!empty($us)) {
				if ($us['User']['status'] == '1') { 
					App::Import('Utility', 'Validation'); 
					$pass 										=	AuthComponent::password($this->data['User']['password']); 
					$user 										=	$this->data['User']['username'];
					$isf 											= 	$this->User->find("first", array("conditions" =>array('AND' => array("User.email" => $user,"User.password"=>$pass))));
					if (!$isf) {
						$response = array('message'=>"Invalid Password",'status' =>0);
						echo json_encode($response);
						exit; 
					} 
					else 
					{	
						$resp 		= "You have successfully logged-In";
						$type 		=$isf['User']['usertype_id'];
						
						if($type == 7){
							if(isset($isf['User']['id'])) {
								$user_id	=	$isf['User']['id'];
							} else {
								$user_id	=	'';
							}
							if(isset($isf['User']['usertype_id'])) {
								$usertype_id	=	$isf['User']['usertype_id'];
							} else {
								$usertype_id	=	'';
							}
							if(isset($isf['User']['email'])) {
								$email	=	$isf['User']['email'];
							} else {
								$email	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['username'])) {
								$username	=	$isf['User']['username'];
							} else {
								$username	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['college'])) {
								$college	=	$isf['User']['college'];
							} else {
								$college	=	'';
							}
							$response = array (
								'status' 			=> 1,
								'message'		=> $resp,
								'user_id' 		=> $user_id,
								'username'	=> $username,
								'college' 		=> $college,
								'image'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'],
								'email'			=> $email,
								'contact'		=> $contact,
								'usertype_id'	=> $usertype_id							
							);
							//pr ($response);die;
							echo json_encode($response);
							exit; 
						}  else  {
							if(isset($isf['User']['id'])) {
								$user_id	=	$isf['User']['id'];
							} else {
								$user_id	=	'';
							}
							if(isset($isf['User']['usertype_id'])) {
								$usertype_id	=	$isf['User']['usertype_id'];
							} else {
								$usertype_id	=	'';
							}
							if(isset($isf['User']['email'])) {
								$email	=	$isf['User']['email'];
							} else {
								$email	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['company_name'])) {
								$company_name	=	$isf['User']['company_name'];
							} else {
								$company_name	=	'';
							}
							if(isset($isf['User']['contact'])) {
								$contact	=	$isf['User']['contact'];
							} else {
								$contact	=	'';
							}
							if(isset($isf['User']['category_id'])) {
								$category_id	=	$isf['User']['category_id'];
							} else {
								$category_id	=	'';
							}
							if(isset($isf['User']['description'])) {
								$description	=	$isf['User']['description'];
							} else {
								$description	=	'';
							}
							$response = array (
								'status' => 1,
								'message'=> $resp,
								'user_id' => $user_id,
								'company_name' => $company_name,
								'image'=>FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'],
								'email'=>$email,
								'contact'=>$contact,
								'category_id'=>$category_id,
								'description'=>$contact,
								'usertype_id' =>$usertype_id							
							);
							//pr ($response);die;
							echo json_encode($response);
							exit; 
						}
					}
				} 
				else 
				{
					$response 									= array('message'=>"Your account has been blocked by Administrator",'status' =>0);
					echo json_encode($response);
					exit; 
				}
			} 
			else {
				$response =array('message'=>"Invalid email id and password",'status' =>0);
				echo json_encode($response);
				exit; 			
			}
		}	
		
		/*	4 API forgot	*/
		// http://dev414.trigma.us/Crowd-Career/Webservices/forgot?email=gurudutt.sharma@trigma.in
		public function forgot () 
		{
		
			$this->User->recursive 		= 	-1;
			$email 								= 	$_REQUEST['email'];
			$fu 									= 	$this->User->find('first', array('conditions' => array('User.email' => $email)));
			if  ($fu['User']['usertype_id'] == 7)  {
				$name = $fu['User']['username'];
			} else {
				$name = $fu['User']['company_name'];
			}
			if ($fu) {
				if ($fu['User']['status'] == "1") {
					$key 						=	Security::hash(String::uuid(), 'sha512', true);
					$hash 						= 	sha1($fu['User']['email'] . rand(0, 100));
					$url 							= 	Router::url(array('controller' => 'admin/users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
					$ms 							= 	"<p>Hi <br/>".$name.",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
					$fu['User']['token'] 		= $key;
					$this->User->id 		= $fu['User']['id'];
					if ($this->User->saveField('token', $fu['User']['token'])) {
						$l 							= new CakeEmail();
						$l->emailFormat ('html')->template ('signup', 'fancy')->subject ('Reset Your Password')->to ($email)->from ('gurudutt.sharma@trigma.in')->send($ms);
						$response				= array('message'=>"Check Your Email To Reset your password");
						echo json_encode($response);
						exit;
					} 
					else 
					{				
						$response 			= array('message'=>"Please try again");
						echo json_encode($response);
						exit;                                
					}
				} 
				else 
				{                             
					$response 				= array('message'=>"Your account has been blocked by Administrator");
					echo json_encode($response);
					exit;
				}
			} 
			else 
			{				
				$response 					= array('message'=>"Email does not exist");
				echo json_encode($response);
				exit;				
			}
		}
		
		/* 5 API (admin_reset )		*/
		//	http://dev414.trigma.us/N-110BB/Webservices/reset?email=gurudutt.sharma@trigma.in
		public function admin_reset($token = null) 
		{
			$this->User->recursive = -1;
			if (!empty($token)) {
				$u = $this->User->findBytoken($token);
				if ($u) {
					$this->User->id = $u['User']['id'];
					if (!empty($this->data)) {
					    if ($this->data['User']['password'] != '') {
							if ($this->data['User']['password_confirm'] != '') {
								if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
									$this->Session->setFlash("Both the passwords are not matching...");
									return;
								}
								$this->User->data = $this->data;
								$this->User->data['User']['username'] = $u['User']['username'];
								$new_hash = sha1($u['User']['username'] . rand(0, 100)); //created token
								$this->User->data['User']['token'] = $new_hash;
								if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
									//	if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
									if ($this->User->save($this->User->data)) {
										echo "Your password has been updated";
										exit;
									}
								} else {
									$this->set('errors', $this->User->invalidFields());
								}
							} else {
								$this->Session->setFlash("Both fields are required...");
								return;
							}
						} else {
								$this->Session->setFlash("Both fields are required...");
								return;
							}
					}
				} else {
					$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
				}
			}
		}
		/* 6 API (change_password)	*/
		//    4. http://dev414.trigma.us/Crowd-Career/webservices/changepass?email=gurudutt.sharma@trigma.in&opass=123456&cpass=gurudutt&newpass=gurudutt

		public function changepass () 
		{         
			$result			=  array();
			$password 	=	AuthComponent::password($_REQUEST['opass']);
			$em				=	$_REQUEST['email'];
			$pass			=	$this->User->find('first',array('conditions'=>array('OR'=>array('User.username'=>$em,'User.email' => $em))));
			//pr ($pass);die;
			if (!empty($pass))  {
				$result['user_id']	=	@$pass['User']['id'];
				if($pass['User']['password']==$password) {
					if($_REQUEST['newpass'] != $_REQUEST['cpass'] ) {
						$result['message']="New password and Confirm password field do not match";                          
					}	
					else 
					{
						$_REQUEST['opass'] 	= $_REQUEST['newpass'];
						$this->User->id 			= $pass['User']['id'];
						if($this->User->exists())	{
							$pass	= array('User'=>array('password'=>$_REQUEST['newpass']));
							if($this->User->save($pass)) {
							   $result['message']	=	"Password updated";                              
							}
						}
					}
				}	else {
					$result['message']				=	"Your old password did not match.";                             
				}        
				echo json_encode($result);
				exit;
			}  else {
				$result['message']				=	"Your email id does not exist.";  
				echo json_encode($result);
				exit;
			}
		}
		
		/* 7 API (MyProfile)	*/
		 //http://dev414.trigma.us/Crowd-Career/webservices/myProfile?id=207
		public function myProfile() 
		{  
			$id	=	$_REQUEST['id'];
			$this->User->id	=	$id;
			if($this->User->exists	())
			{    
				$user=$this->User->find('all',array('conditions'=>  array('User.id'=>$id)));
				foreach ($user as $key => $value) {
					if(!empty($value['User']['profile_image'])){
					$profileImage = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'];
					
					} else {
					$profileImage = '';
					}
					if(isset($value['User']['username'])) {
						$username	=	$value['User']['username'];
					} else {
						$username	=	'';
					}
					if(isset($value['User']['college'])) {
						$college	=	$value['User']['college'];
					} else {
						$college	=	'';
					}
					if(isset($value['User']['email'])) {
						$email	=	$value['User']['email'];
					} else {
						$email	=	'';
					}
					if(isset($value['User']['contact'])) {
						$contact	=	$value['User']['contact'];
					} else {
						$contact	=	'';
					}
					if(isset($value['User']['address'])) {
						$address	=	$value['User']['address'];
					} else {
						$address	=	'';
					}
					if(isset($value['User']['first_name'])) {
						$first_name	=	$value['User']['first_name'];
					} else {
						$first_name	=	'';
					}
					if(isset($value['User']['birthday'])) {
						$birth_day	=	$value['User']['birthday'];
					} else {
						$birth_day	=	'';
					}
					if(isset($value['User']['register_date'])) {
						$register_date	=	$value['User']['register_date'];
					} else {
						$register_date	=	'';
					}
					$data=  array(
						'id'=>$value['User']['id'],
						'username'=>$username,
						'college'=>$college,
						'email'=>$email,
						'profile_image'=>$profileImage,
						'contact'=>$contact,
						'address'=>$address,
						'name'=>$first_name,
						'date of birth'=>$birth_day,
						'register_date'=>$register_date,
						'status'=>1
						);
				}        
				echo json_encode($data);exit;
			} else {
				$data = array('status'=>0,'msg'=>'Invalid User');
				 echo json_encode($data);exit;
			}    
		}
		
		/* 8 API (profile_edit) */
		// http://dev414.trigma.us/N-110BB/webservices/profile_edit?id=207&username=guru&first_name=sharma&profile_image=images.png&contact=9546356		

		public function profile_edit() 
		{
			$this->User->id = $_REQUEST['id'];
			if (!$this->User->exists()) 
			{
				throw new NotFoundException(__('Invalid user'));
			}
			$result	=  array ();
			if(!empty($_REQUEST['username'])) 
			{
				$this->request->data['User']['username']=$_REQUEST['username'];
			} else 
			{
				 $this->request->data['User']['username']='';
			}
			if(!empty($_REQUEST['first_name']))
			{
				$this->request->data['User']['first_name']=$_REQUEST['first_name'];
			} else 
			{
				 $this->request->data['User']['first_name']='';
			}							
			if(!empty($_REQUEST['contact']))
			{
				$this->request->data['User']['contact']=$_REQUEST['contact'];
			} else 
			{
				 $this->request->data['User']['contact']='';
			}				
			$id = $_REQUEST['id'];
			if ($this->User->save($this->request->data)) {
				if(isset($_REQUEST['profile_image'])&&!empty($_REQUEST['profile_image']))
				{
					$ti=date('Y-m-d-g:i:s');
					$dname= $ti.$id."image.png";
					$this->User->saveField('profile_image',$dname);
					@$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', $_REQUEST['profile_image']);
					$_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
					$unencodedData=base64_decode($_REQUEST['profile_image']);
					$pth3 = WWW_ROOT.'files' . DS . 'profileimage'. DS .$dname;
					file_put_contents($pth3, $unencodedData);
				}
				$user=$this->User->find('first',array('conditions'=>  array('User.id'=>$id)));	
				if(!empty($user['User']['profile_image'])){
					$profileImage = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'];
				} else {
					$profileImage = '';
				}
				if($user['User']['usertype_id']	!= ''){
					$user['User']['usertype_id'] 	=	$user['User']['usertype_id'];
				} else {
					 $user['User']['usertype_id'] =	'';
				}
				if($user['User']['username'] != ''){
					$user['User']['username']	=	$user['User']['username'];
				} else {
					$user['User']['username']	='';
				}			
				if($user['User']['first_name']	!= ''){
					$user['User']['first_name'] 	=	$user['User']['first_name'];
				} else {
					 $user['User']['first_name'] =	'';
				}
				if($user['User']['contact'] != ''){
					$user['User']['contact']	=	$user['User']['contact'];
				} else {
					$user['User']['contact']	='';
				}		
				$result['usertype_id']= $user['User']['usertype_id']; 
				$result['username']= $user['User']['username']; 
				$result['name']= $user['User']['first_name']; 
				$result['image']= $profileImage; 
				$result['contact']= $user['User']['contact']; 
				$result['message']= 'The details has been updated';
			} 
			else {
				$result['message']= 'The details could not be saved. Please, try again.';    
			}
			echo json_encode($result);
			exit();
		}	
		
		/* 9 API (Category Listing)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/topics
		public function topics () 
		{
			$this->loadModel ("Category");	
			$data 	= 	$this->Category->find ('all');
			//pr ($data);die;
			if (!empty($data)) {
				foreach($data as $key=>$value) {
					$response[]	=	array(
						'status'				=>1,
						'category_id'		=>@$value['Category']['id'],
						'category_name'=>@$value['Category']['name']										
					);
				}
				echo json_encode($response);exit;
			} else {
				$response[] = array('status'=>0,'msg'=>'no category found.');
				echo json_encode ($response);exit;
			}		
		}
		
		/* 10 API (companies_list)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/companies_list?category_id=2&follower_id=5&usertype_id=8
		public function companies_list () 
		{
			$this->loadModel ("User");
			$category_id						=	$_REQUEST['category_id'];			
			$this->User->virtualFields	=	array ('followers'=>'select count(id) from employer_followers where User.id = employer_followers.user_id');
			$data = $this->User->find ('all',array('conditions'=>array('User.usertype_id'=>8,'User.category_id'=>$category_id)));
			//pr ($data);die;
			if (!empty($data)) {
				foreach($data as $key=>$value) {
					$response[]=array(
						'id'						=> @$value['User']['id'],
						'category_id'			=> @$value['User']['category_id'],
						'category_name'	=> @$value['Topic']['name'],
						'company_name'	=> @$value['User']['company_name'],
						'image'					=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'],						
						'email'					=> @$value['User']['email'],
						'contact' 				=> @$value['User']['contact'],
						'description' 			=> @$value['User']['description'],
						'followers' 				=> @$value['User']['followers'],
						'status'				 	=> 1				
					);
				}
				//pr($response);die;
				echo json_encode($response);exit;
			} else {
				$response[] = array('status'=>0,'msg'=>'no company found.');
				echo json_encode ($response);exit;
			}			
		}
		
		/* 11 API (student_list) */
		//http://dev414.trigma.us/Crowd-Career/Webservices/student_list/
		public function student_list () 
		{
			$this->loadModel ("User");
			$this->User->virtualFields	=	array ('followers'=>'select count(id) from student_followers where User.id = student_followers.user_id');
			$data = $this->User->find ('all',array('conditions'=>array('User.usertype_id'=>7)));
			//pr ($data);die;
			if (!empty($data)) {
				foreach($data as $key=>$value) {
					$response[]=array(
						'id'						=> @$value['User']['id'],
						'display_name'		=> @$value['User']['username'],
						'image'					=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'],	
						'college'					=> @$value['User']['college'],
						'email'					=> @$value['User']['email'],
						'contact' 				=> @$value['User']['contact'],
						'followers' 				=> @$value['User']['followers'],
						'status'				 	=> 1				
					);
				}
				//pr($response);die;
				echo json_encode($response);exit;
			} else {
				$response = array('status'=>0,'msg'=>'no company found.');
				echo json_encode ($response);exit;
			}			
		}
		
		/* 12 API (student followers)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/student_followers?user_id=2260&follower_id=3236&user_types_id=7
		public function student_followers () 
		{
			$this->loadModel ('StudentFollower');
			$data['StudentFollower']['user_id']			=	$_REQUEST['user_id'];
			$data['StudentFollower']['follower_id']		=	$_REQUEST['follower_id'];
			$data['StudentFollower']['user_types_id']	=	$_REQUEST['user_types_id'];
			
			$user_exist 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['follower_id'],'User.usertype_id'=>$_REQUEST['user_types_id'])));
			$check_user = $this->StudentFollower->find ('first',array('conditions'=>array('StudentFollower.follower_id'=>$_REQUEST['follower_id'])));
			
			if (!empty($user_exist))  {
				if (empty($check_user)) {
					if($this->StudentFollower->save($data))  {
						$response[] = array('status'=>1,'msg'=>'success.');
						echo json_encode ($response);exit;
					}  else  {
						$response[] = array('status'=>0,'msg'=>'error.');
						echo json_encode ($response);exit;
					}
				} else {
					$response[] = array('status'=>0,'msg'=>'follower already exist.');
					echo json_encode ($response);exit;
				}
			}
			$response[] = array('status'=>0,'msg'=>'follower already exist.');
			echo json_encode ($response);exit;
		}
		
		/* 13 API companies_list	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/employer_follower?user_id=2260&follower_id=3236&user_types_id=7
		public function employer_follower () 
		{
			$this->loadModel ('User');
			$this->loadModel ('EmployerFollower');
			$data['EmployerFollower']['user_id']				=	$_REQUEST['user_id'];
			$data['EmployerFollower']['follower_id']		=	$_REQUEST['follower_id'];
			$data['EmployerFollower']['user_types_id']	=	$_REQUEST['user_types_id'];
			
			$user_exist 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['follower_id'],'User.usertype_id'=>$_REQUEST['user_types_id'])));
			$check_user = $this->EmployerFollower->find ('first',array('conditions'=>array('EmployerFollower.follower_id'=>$_REQUEST['follower_id'])));
			
			if (!empty($user_exist))  {
				if (empty($check_user)) {
					if($this->EmployerFollower->save($data))  {
						$response[] = array('status'=>1,'msg'=>'success.');
						echo json_encode ($response);exit;
					}  else  {
						$response[] = array('status'=>0,'msg'=>'error.');
						echo json_encode ($response);exit;
					}
				} else {
					$response[] = array('status'=>0,'msg'=>'follower already exist.');
					echo json_encode ($response);exit;
				}
			}  else {
				$response[] = array('status'=>0,'msg'=>'follower not exist.');
				echo json_encode ($response);exit;
			}
		}
		
		/* 14 API (student unfollow)		*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/student_unfollow?user_id=2260&follower_id=3236
		public function student_unfollow () 
		{
			$this->loadModel ('StudentFollower');
			$data['StudentFollower']['user_id']			=	$_REQUEST['user_id'];
			$data['StudentFollower']['follower_id']		=	$_REQUEST['follower_id'];
			$check_user = $this->StudentFollower->find ('first',array('conditions'=>array('StudentFollower.follower_id'=>$_REQUEST['follower_id'])));
			if (!empty($check_user)) {
				if($this->StudentFollower->deleteAll (array('StudentFollower.follower_id' => $_REQUEST['follower_id'])))  {
					$response[] = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}  else  {
					$response[] = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'Follower not exist.');
				echo json_encode ($response);exit;
			}
		}
		
		/* 15 API (Employer unfollow)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/employer_unfollow?user_id=2260&follower_id=3236
		public function employer_unfollow () 
		{
			$this->loadModel ('EmployerFollower');
			$data['EmployerFollower']['user_id']				=	$_REQUEST['user_id'];
			$data['EmployerFollower']['follower_id']		=	$_REQUEST['follower_id'];
			$check_user = $this->EmployerFollower->find ('first',array('conditions'=>array('EmployerFollower.follower_id'=>$_REQUEST['follower_id'])));
			if (!empty($check_user)) {
				if($this->EmployerFollower->deleteAll (array('EmployerFollower.follower_id' => $_REQUEST['follower_id'])))  {
					$response[] = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}  else  {
					$response[] = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'follower already exist.');
				echo json_encode ($response);exit;
			}
		}
		
		/* 16 API   (Company connection with student)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/company_connection_student?company_id=2260
		public function company_connection_student()
		{
			$this->loadModel ('User'); 
			$user_id	=	$_REQUEST['company_id'];
			
			$data 		=	$this->User->find ('first',array('conditions'=>array('User.id'=>$user_id),'contain'=>array('EmployerFollower'=>array('User.id','User.username','User.college','User.usertype_id','User.profile_image'))));
			
			if (!empty($data)) {				
				if (!empty($data['EmployerFollower']))  {
					$response = array();
					foreach($data['EmployerFollower'] as $info) {
						if ($info['user_types_id'] == 7) {
							$response[]=array(
								'company_id'					=> @$info['id'],
								'company_name'			=> @$data['User']['company_name'],
								'follower_id'					=> @$info['User']['id'],
								'follower_display_name'	=> @$info['User']['username'],
								'follower_image'				=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'],	
								'follower_college'			=> @$info['User']['college'],
								'status'				 			=> 1				
							);
						} 
					}
					if (empty($response)) {
						$response[] = array('status'=>0,'msg'=>'no follower found.');
					}
					//pr($response);die;
					echo json_encode($response);exit;
				}  else {
					$response[] = array('status'=>0,'msg'=>'no follower found.');
					echo json_encode ($response);exit;
				}
				
			} else {
				$response[] = array('status'=>0,'msg'=>'user not found.');
				echo json_encode ($response);exit;
			}	
		}
		
		/* 17 API  (Company connection with company)		*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/company_connection_company?company_id=2260
		public function company_connection_company()
		{
			$this->loadModel ('User');
			$user_id	=	$_REQUEST['company_id'];
			$data 		=	$this->User->find ('first',array('conditions'=>array('User.id'=>$user_id),'contain'=>array('EmployerFollower'=>array('User.id','User.company_name','User.college','User.usertype_id','User.profile_image'))));
			if (!empty($data)) {				
				if (!empty($data['EmployerFollower']))  {
					$response = array();
					foreach($data['EmployerFollower'] as $info) {
						if ($info['user_types_id'] == 8) {
							$response[]=array(
								'company_id'						=> @$info['id'],
								'company_name'				=> @$data['User']['company_name'],
								'follower_id'						=> @$info['User']['id'],
								'follower_company_name'	=> @$info['User']['company_name'],
								'follower_image'					=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'],	
								'status'				 				=> 1				
							);
						} 
					}
					if (empty($response)) {
						$response[] = array('status'=>0,'msg'=>'no follower found.');
					}
					//pr($response);die;
					echo json_encode($response);exit;
				}  else {
					$response[] = array('status'=>0,'msg'=>'no follower found.');
					echo json_encode ($response);exit;
				}
				
			} else {
				$response[] = array('status'=>0,'msg'=>'user not found.');
				echo json_encode ($response);exit;
			}	
		}
		/* 18 API (Company profile) */
		//http://dev414.trigma.us/Crowd-Career/Webservices/company_profile?user_id=2261
		public function company_profile() 
		{
			$this->loadModel('User');
			$this->User->virtualFields	=	array ('followers'=>'select count(id) from employer_followers where User.id ='.$_REQUEST['user_id'].'');
			$user_data	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id'])));
			//pr ($user_data);die;
			if ($user_data['User']['address'] == '')  {
				$user_data['User']['address'] = 'N/A';
			}
			if ($user_data['User']['website'] == '')  {
				$user_data['User']['website'] = 'N/A';
			}
			if (!empty($user_data))  {
				$response[]=array(
					'company_id'			=> @$user_data['User']['id'],
					'company_name'	=> @$user_data['User']['company_name'],
					'description'			=> @$user_data['User']['description'],
					'profile_image'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user_data['User']['profile_image'],	
					'followers'			 	=> @$user_data['User']['followers'],			
					'employes'				=> @$user_data['User']['employes'],			
					'address'			 	=> @$user_data['User']['address'],			
					'website'				=> @$user_data['User']['website'],			
					'status'				 	=> 1				
				);
				//pr($response);die;
				echo json_encode($response);exit;
			}  else {
				$response[] = array('status'=>0,'msg'=>'no record found.');
				echo json_encode ($response);exit;
			}
		}
		
		/* 19 API (Employer Profile) */
		//http://dev414.trigma.us/Crowd-Career/Webservices/employe_profile?user_id=2261
		public function employe_profile() 
		{
			$this->loadModel('User');
			$this->User->virtualFields	=	array ('followers'=>'select count(id) from employer_followers where User.id ='.$_REQUEST['user_id'].'');
			$user_data	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id'])));
			//pr ($user_data);die;
			if ($user_data['User']['address'] == '')  {
				$user_data['User']['address'] = 'N/A';
			}
			if ($user_data['User']['website'] == '')  {
				$user_data['User']['website'] = 'N/A';
			}
			if (!empty($user_data))  {
				$response[]=array(
					'company_id'			=> @$user_data['User']['id'],
					'company_name'	=> @$user_data['User']['company_name'],
					'description'			=> @$user_data['User']['description'],
					'profile_image'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user_data['User']['profile_image'],	
					'type'			 	=> @$user_data['Category']['name'],		
					'status'				 	=> 1				
				);
				//pr($response);die;
				echo json_encode($response);exit;
			}  else {
				$response[] = array('status'=>0,'msg'=>'no record found.');
				echo json_encode ($response);exit;
			}
		}
		
		/* 20 API (Student profile)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/student_profile?user_id=2260
		public function student_profile() 
		{
			$this->loadModel('User');
			$user_data	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id'])));
			//pr ($user_data);die;
			if (!empty($user_data))  {
				$response[]=array(
					'user_id'			=> @$user_data['User']['id'],
					'username'		=> @$user_data['User']['username'],
					'college'				=> @$user_data['User']['college'],
					'profile_image'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user_data['User']['profile_image'],	
					'status'				=> 1				
				);
				//pr($response);die;
				echo json_encode($response);exit;
			}  else {
				$response[] = array('status'=>0,'msg'=>'no record found.');
				echo json_encode ($response);exit;
			}
		}
		
		/* 21 API People You May Know */
		//http://dev414.trigma.us/Crowd-Career/Webservices/people_you_may_know?user_id=2260
		public function people_you_may_know() 
		{
			$this->loadModel ('User');
			$get_data	=	$this->User->find(
				'first',array(
					'conditions'=>array(
						'User.id'=>$_REQUEST['user_id']
					),
					'contain'=>array(
						'EmployerFollower'=>array(
							'User.id' ,
						),
						'StudentFollower'=>array(
							'User.id'
						)
					)
				)
			);
			$student_followers		=	array();
			$employer_follower	=	array();
			
			foreach ($get_data['StudentFollower'] as $info) {
				array_push ($student_followers,$info['User']['id']);
			}
			
			foreach ($get_data['EmployerFollower'] as $info1) {
				array_push ($employer_follower,$info1['User']['id']);
			}
			
			$people_id 			= 	array_merge ($student_followers,$employer_follower);
			
			# Get unique ids
			$people_unique_id	=	array_unique ($people_id);
			
			$people_data			=	$this->User->find(
				'all',array(
					'conditions'=>array("NOT"=>array(
							'User.id'=>$people_unique_id
						)
					),
					'contain'=>array()
				)
			);
			if (!empty($people_data)) {
				foreach ($people_data as $info) {
					if ($info['User']['id'] != $_REQUEST['user_id']) {
						if ($info['User']['usertype_id'] == '7') {
							$response[] = array (
								'status' 				=> 1,
								'follower_id'		=> $info['User']['id'],
								'user_id' 			=> $_REQUEST['user_id'],
								'name'				=> $info['User']['username'],
								'profile'				=> 'Student',
								'college' 			=> $info['User']['college'],
								'image'				=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'],
								'email'				=> $info['User']['email'],
								'contact'			=> $info['User']['contact'],
								'usertype_id'		=> $info['User']['usertype_id']							
							);
						}
						if ($info['User']['usertype_id'] == '8') {
							$response[] = array (
								'status' 			=> 1,
								'follower_id'	=> $info['User']['id'],
								'user_id' 		=> $_REQUEST['user_id'],
								'name'			 	=> $info['User']['company_name'],
								'profile'			=> 'Company',
								'image'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'],
								'email'				=> $info['User']['email'],
								'contact'			=> $info['User']['contact'],
								'category_id'	=> $info['User']['category_id'],
								'description'	=> $info['User']['description'],
								'usertype_id' 	=> $info['User']['usertype_id']							
							);
						}
					}
				}
				//pr ($response);die;
				if (empty($response)) {
					$response[] = array('status'=>0,'msg'=>'user not found.');
					echo json_encode ($response);exit;
				}
				echo json_encode($response);exit;
			} else {
				$response[] = array('status'=>0,'msg'=>'user not found.');
				echo json_encode ($response);exit;
			}			
			//pr ($people_data);die;
		}
		
		/* 22 API   (Student connection with company)	*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/student_connection_student?user_id=2260
		public function student_connection_student()
		{
			$this->loadModel ('User');
			$user_id	=	$_REQUEST['user_id'];
			
			$data 		=	$this->User->find ('first',array('conditions'=>array('User.id'=>$user_id),'contain'=>array('StudentFollower'=>array('User.id','User.username','User.college','User.usertype_id','User.profile_image'))));
			
			if (!empty($data)) {				
				if (!empty($data['StudentFollower']))  {
					$response = array();
					foreach($data['StudentFollower'] as $info) {
						if ($info['user_types_id'] == 7) {
							$response[]=array(
								'user_id'							=> @$info['id'],
								'name'								=> @$info['User']['username'],
								'profile'							=> 'Student',
								'follower_id'					=> @$info['User']['id'],
								'usertype_id'					=> @$info['User']['usertype_id'],
								'follower_display_name'	=> @$info['User']['username'],
								'follower_image'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'],	
								'follower_college'			=> @$info['User']['college'],
								'status'				 			=> 1				
							);
						} 
					}
					if (empty($response)) {
						$response[] = array('status'=>0,'msg'=>'no follower found.');
					}
					//pr($response);die;
					echo json_encode($response);exit;
				}  else {
					$response[] = array('status'=>0,'msg'=>'no follower found.');
					echo json_encode ($response);exit;
				}
				
			} else {
				$response[] = array('status'=>0,'msg'=>'user not found.');
				echo json_encode ($response);exit;
			}	
		}
		
		/* 23 API  (Student connection with company)		*/
		//http://dev414.trigma.us/Crowd-Career/Webservices/student_connection_company?user_id=2260
		public function student_connection_company()
		{
			$this->loadModel ('User');
			$user_id	=	$_REQUEST['user_id'];
			$data 		=	$this->User->find ('first',array('conditions'=>array('User.id'=>$user_id),'contain'=>array('StudentFollower'=>array('User.id','User.company_name','User.college','User.usertype_id','User.profile_image'))));
			if (!empty($data)) {				
				if (!empty($data['StudentFollower']))  {
					$response = array();
					foreach($data['StudentFollower'] as $info) {
						if ($info['user_types_id'] == 8) {
							$response[]=array(
								'user_id'									=> @$info['id'],
								'name'										=> @$info['User']['company_name'],
								'profile'									=> 'Company',
								'usertype_id'							=> @$info['User']['usertype_id'],
								'follower_id'							=> @$info['User']['id'],
								'follower_company_name'	=> @$info['User']['company_name'],
								'follower_image'					=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'],	
								'status'				 					=> 1				
							);
						} 
					}
					if (empty($response)) {
						$response[] = array('status'=>0,'msg'=>'no follower found.');
					}
					//pr($response);die;
					echo json_encode($response);exit;
				}  else {
					$response[] = array('status'=>0,'msg'=>'no follower found.');
					echo json_encode ($response);exit;
				}
				
			} else {
				$response[] = array('status'=>0,'msg'=>'user not found.');
				echo json_encode ($response);exit;
			}	
		}
		
		/* 24 API (Job Post By Employer) */
		//http://dev414.trigma.us/Crowd-Career/Webservices/post_jobs?user_id=2260&category_id=2&job_title=php&location=Noida&image=image.png&responsibilities=php&skills=Noida&experience=image&description=gugugugugu
		public function post_jobs() 
		{
			$this->loadModel ('Job');
			$data['Job']['user_id']				=	$_REQUEST['user_id'];
			$data['Job']['category_id']		=	$_REQUEST['category_id'];
			$data['Job']['job_title']				=	$_REQUEST['job_title'];
			$data['Job']['location']				=	$_REQUEST['location'];
			$data['Job']['image']				=	$_REQUEST['image'];
			$data['Job']['skills']					=	$_REQUEST['skills'];
			$data['Job']['responsibilities']	=	$_REQUEST['responsibilities'];
			$data['Job']['experience']		=	$_REQUEST['experience'];
			$data['Job']['description']		=	$_REQUEST['description'];
			$data['Job']['date']					=	date ('Y-m-d');
			if ($_REQUEST['user_id'] == '' or $_REQUEST['category_id'] == '' or $_REQUEST['job_title'] == '' or $_REQUEST['location'] == '') {
				$response[] = array('status'=>0,'msg'=>'Error: All fields are required.');
				echo json_encode ($response);exit;
			} else {
				if($this->Job->save ($data))  {
					$response[] = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}  else  {
					$response[] = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			}
		}
		
		/* 25 API (Global API for Jobs) */
		//http://dev414.trigma.us/Crowd-Career/Webservices/jobs?category_id=2,job_id=8
		public function jobs() 
		{
			$this->loadModel ('Job');
			$job_id			=	@$_REQUEST['job_id'];
			$category_id	=	@$_REQUEST['category_id'];
			if ($job_id != '')  {
				$user	=	$this->Job->find('all',array('conditions'=>array('Job.id'=>$job_id)));
			}  elseif ($category_id  != '')  {
				$user	=	$this->Job->find('all',array('conditions'=>array('Job.category_id'=>$category_id)));
			}  else {
				$user	=	$this->Job->find('all');
			}
			
			if (!empty($user)) {
				foreach($user as $info) {
					$response[]=array(
						'job_id'					=> @$info['Job']['id'],
						'user_id'				=> @$info['Job']['user_id'],
						'category_id'			=> @$info['Job']['category_id'],
						'job_title'				=> @$info['Job']['job_title'],					
						'location'				=> @$info['Job']['location'],					
						'responsibilities'		=> @$info['Job']['responsibilities'],					
						'skills'					=> @$info['Job']['skills'],					
						'experience'			=> @$info['Job']['experience'],					
						'description'			=> @$info['Job']['description'],					
						'category_name'	=> @$info['Category']['name'],					
						'posted'					=> @$info['Job']['date'],					
						'status'				 	=> 1				
					);
				}	
				//pr($response);die;
				echo json_encode($response);exit;
			}  else  {
				$response[] = array('status'=>0,'msg'=>'jobs not found.');
				echo json_encode ($response);exit;
			}
		}
	
		/* 25 API (Apply for job) */
		//http://dev414.trigma.us/Crowd-Career/Webservices/apply_job?job_id=2260&user_id=2&cv=php&certificate_degree=Noida
		public function apply_job() 
		{
			$this->loadModel ('JobsApply');
			$data['JobsApply']['job_id']						=	$_REQUEST['job_id'];
			$data['JobsApply']['user_id']						=	$_REQUEST['user_id'];
			$data['JobsApply']['cv']								=	$_REQUEST['cv'];
			$data['JobsApply']['certificate_degree']		=	$_REQUEST['certificate_degree'];
			$data['JobsApply']['date']							=	date ('Y-m-d');
			if ($_REQUEST['job_id'] == '' or $_REQUEST['user_id'] == '' or $_REQUEST['cv'] == '' or $_REQUEST['certificate_degree'] == '') {
				$response[] = array('status'=>0,'msg'=>'Error: All fields are required.');
				echo json_encode ($response);exit;
			} else {
				if($this->JobsApply->save ($data))  {
					if(@$_REQUEST['cv']!='') {  
						$name					=  $user_id."cv.png";
						$this->User->saveField('cv',$name);
						@$_REQUEST['cv']	=  str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
						$_REQUEST['cv'] 		=  str_replace(' ', '+',$_REQUEST['cv']);
						$unencodedData						=  base64_decode($_REQUEST['cv']);
						$pth 											=  WWW_ROOT.'files' . DS . 'cv' . DS .$name;
						file_put_contents($pth, $unencodedData);
					}
					$response[] = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}  else  {
					$response[] = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			}
		}
		
		
		
	}