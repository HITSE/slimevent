<?php
/**
 * SEHomeClass
 *
 * @package   Slimevent
 **/

/**
 * Action for Home
 */

class SEHome{

	function test()
	{
		$user = array();
		$user['name'] = "cca";
		$user['pwd'] = "bbbb";
		$user['group'] = "ccc";

		$data = array();
		$data['name'] = "lihai";
		$data['no'] = "831";
		$data['sex'] = "female";
		$data['class'] = "667";
		$data['college'] = "hit";
		$data['major'] = "aa";
		$data['avatar'] = "12";
		$data['email'] = "@mail";
		$data['phone'] = "11111";
		$data['introduction'] = "woaipingpang";
		//Admin::edit_user_info(6,'club',$data);
		Admin::reset_user_pwd(1,123);
	}


	function run()
	{
		echo Template::serve('index.html');
		//if(Account::is_login() === TRUE)
			//echo Template::serve('hello.html');
		//else
			//F3::reroute('/accounts/admin/login');
	}

	function show_login()
	{	
		switch(F3::get('GET.auth'))
		{
			case F3::get('CAS_AUTH'):
				$user = CAS::login();

				$name = $user['stu_id'];
				$pwd = md5(F3::get('DEFAULT_PWD'));
				$group = F3::get('STUDENT_GROUP');

				if(Student::exists($name) === FALSE)
					Student::insert($name, $pwd, $group);

				Account::login($name, $pwd);
				break;
			case F3::get('CLUB_AUTH'):
				echo Template::serve('club/login.html');
				return;
			default:
				F3::reroute('/');
		}

		F3::reroute('/');
	}

	function login()
	{
		$user_name = F3::get('POST.user_name');
		$user_pwd = F3::get('POST.user_pwd');

		$user = Account::login($user_name, $user_pwd); 

		if($user === FALSE){
			F3::reroute('/club/login/?show_msg=1');  
		} else {
			F3::reroute('/');
		}
	}

	function logout()
	{
		switch(Account::the_user_group())
		{
			case F3::get('STUDENT_GROUP'):
				Account::logout();
				CAS::logout();
				break;
			default:
				Account::logout();
		}

		F3::reroute('/');
	}

};

?>
