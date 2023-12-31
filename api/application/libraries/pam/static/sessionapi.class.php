<?php
// namespace PamFaxApi;
/**
* Manage users sessions.
* 
* The Session API contains functionality to create, keep alive and terminate
* sessions along with the possibility to retrieve relevant changes from other
* sessions of the given user.
*/
class SessionApi extends ApiClient
{
	/**
	* Verifies a PamFax user via username/password
	* @param string $username Username of the user or the md5 of user's username. That's what he has entered when he registered
	* @param string $password The password (or the md5 of the password) that the user entered in the registration process for the given username (case sensitive)
	* @param <string> $user_ip The IP address of the client on which this identifier will be bound to. Using the identfier from a different ip address will fail
	* @param <int> $timetolifeminutes Optional a lifetime of this identifier. Defaults to 60 seconds. If <= 0 is given, the identifier does not expire and can be used more then once, but are tied to your current API key and can not be passed to online shop, portal, ... in the url
	*/
	public static function VerifyUser($username, $password, $remember_me = false, $user_ip = '', $timetolifeminutes = '')
	{
		return self::StaticApi('Session/VerifyUser',array('username' => $username, 'password' => $password, 'remember_me' => $remember_me, 'user_ip' => $user_ip, 'timetolifeminutes' => $timetolifeminutes),false);
	}

	/**
	* Creates an identifier for the current user
	* 
	* The created identifier then can be passed to the portal to directly log in the user: https://portal.pamfax.biz/?_id=<identifier>
	* Be aware that these identifiers are case sensitive. Identifiers with ttl > 0 can only be used once.
	* @param <string> $user_ip The IP address of the client on which this identifier will be bound to. Using the identfier from a different ip address will fail
	* @param <int> $timetolifeminutes Optional a lifetime of this identifier. Defaults to 60 minutes. If <= 0 is given, the identifier does not expire and can be used more then once, but are tied to your current API key and can not be passed to online shop, portal, ... in the url
	*/
	public static function CreateLoginIdentifier($user_ip = false, $timetolifeminutes = 60)
	{
		return self::StaticApi('Session/CreateLoginIdentifier',array('user_ip' => $user_ip, 'timetolifeminutes' => $timetolifeminutes),false);
	}

	/**
	* Returns the current user object.
	* 
	* Use this if you need to ensure that your locally stored user
	* object is up to date.
	*/
	public static function ReloadUser()
	{
		return self::StaticApi('Session/ReloadUser',array(),true);
	}

	/**
	* Returns all changes in the system that affect the currently logged in user.
	* 
	* This could be changes to the user's profile, credit, settings, ...
	* Changes will be deleted after you received them once via this call, so use it wisely ;)
	*/
	public static function ListChanges()
	{
		return self::StaticApi('Session/ListChanges',array(),false);
	}

	/**
	* Depricated from 3.5MR3. Call Session::KeepAlive()
	*/
	public static function Ping()
	{
		return self::StaticApi('Session/Ping',array(),false);
	}

	/**
	* Just keeps a session alive.
	* 
	* If there is no activity in a Session for 10 minutes, it will be terminated.
	* You then would need to call Session::VerifyUser again and start a new FaxJob
	*/
	public static function KeepAlive()
	{
		return self::StaticApi('Session/KeepAlive',array(),false);
	}

	/**
	* Terminate the current session.
	*/
	public static function Logout()
	{
		return self::StaticApi('Session/Logout',array(),false);
	}

	/**
	* Registers listeners for the current session.
	* 
	* Any change of the listened types will then be available via Session::ListChanges function
	* @param array $listener_types Array of types to be registered ('faxall','faxsending','faxsucceeded','faxfailed','faxretrying')
	* @param bool append if true will append the listeners to the currently registered once, else will replace
	*/
	public static function RegisterListener($listener_types, $append = false)
	{
		return self::StaticApi('Session/RegisterListener',array('listener_types' => $listener_types, 'append' => $append),false);
	}

	/**
	* Remove identifier for current logged-in user
	* @param string $identifier Identifier ID
	*/
	public static function RemoveLoginIdentifier($identifier)
	{
		return self::StaticApi('Session/RemoveLoginIdentifier',array('identifier' => $identifier),false);
	}
}
