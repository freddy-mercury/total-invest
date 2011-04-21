<?
class AuthController {
	private $form_errors = array();
    private static $instance;
    private function __construct() {
    	
    }
    /**
     * GetInstance
     *
     * @return AuthController
     */
	public static function getInstance() {
		if (!isset($GLOBALS['AUTH_INSTANCE']) || !($GLOBALS['AUTH_INSTANCE'] instanceof AuthController)) {
			$c = __CLASS__;
			$GLOBALS['AUTH_INSTANCE'] = new $c;
		}
		return $GLOBALS['AUTH_INSTANCE'];
	}
	public function authorize($login, $password, $secpin) {
		$user_id = sql_get('
			SELECT id 
			FROM users 
			WHERE 
				login="'.$login.'" AND STRCMP(password, "'.$password.'")=0 AND status>0'.(LOGIN_PIN ? ' AND secpin="'.$secpin.'"' : ''));
		if ($user_id) {
			$_SESSION['CUR_USER']['id'] = $user_id;
			Project::getInstance()->resetCurUser($user_id);
		}
	}
	public function isAuthorized() {
		if (Project::getInstance()->getCurUser()->id) {
			return true;
		}
		return false;
	}
}