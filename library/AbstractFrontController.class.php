<?php

/**
 * Абстрактный класс-контроллер действий
 * Действия описываются методами, например actionEdit(), которые запускаются в зависимости от пришедшего параметра,
 * определенного в @method actionParameterName().
 *
 * @author k.komarov
 */
abstract class AbstractFrontController {

	protected $parameters;
	protected $breadcrumbs;

	/**
	 * Возвращает название параметра действия. По-умолчанию: action
	 * @return string
	 */
	protected function actionParameterName() {
		return 'action';
	}

	/**
	 * Конструктор
	 * @param array|NULL $parameters Массив с параметрами (чаще всего $_REQUEST, $_GET или $_POST), если NULL, то по-умолчанию присваевается $_REQUEST
	 */
	public function __construct(array $parameters = NULL) {
		$this->parameters = is_null($parameters) ? (array) $_REQUEST : (array) $parameters;
		$this->init();
	}

	/**
	 * Инициализация
	 * Здесь устанавливаются заголовок страницы и хлебные крошки и происходит авторизация
	 */
	protected function init() {

	}

	/**
	 * Метод, который вызывается по-умолчанию при отсутствии действия.
	 */
	protected function actionIndex() {
	}

	/**
	 * Возвращает текущего действия, если не определено, то actionIndex.
	 * @return string
	 */
	final public function getAction() {
		return isset($this->parameters[$this->actionParameterName()]) &&
				is_string($this->parameters[$this->actionParameterName()]) &&
				!empty($this->parameters[$this->actionParameterName()]) ?
				$this->parameters[$this->actionParameterName()] : 'Index';
	}

	/**
	 * Возвращает название метода для текущего действия.
	 * @return string
	 */
	final public function getActionMethod() {
		$words = explode('_', strtolower($this->getAction()));
		return 'action' . implode('', array_map('ucfirst', $words));
	}

	/**
	 * Возвращает ссылку на действие контроллера.
	 * @param array $action Имя действия. Если не указано, тогда используется текущее действие.
	 * @param array $parameters Параметры для добавления к GET запросу.
	 * @return string Относительная ссылка.
	 */
//	final public function getActionUrl($action = '', $parameters = array()) {
//		$parameters[$this->actionParameterName()] = $action ?: ($this->getAction() === 'Index' ? '' : $this->getAction()) ;
//		return replace_uri_parameter($_SERVER['PHP_SELF'], $parameters);
//	}

	/**
	 * Возвращает занчение параметра, иначе NULL.
	 * @param string $name
	 * @return mixed
	 */
	final protected function getParam($name) {
		return isset($this->parameters[$name]) ? $this->parameters[$name] : NULL;
	}

	/**
	 * Запускает выполнение контроллера
	 */
	final public function run() {
		if ($this->getAction() && method_exists($this, $this->getActionMethod())) {
			$action_method = $this->getActionMethod();
			if (method_exists($this, $action_method)) {
				if ($this->beforeAction()) {
					$this->$action_method();
					$this->afterAction();
					exit(0);
				}
			}
		}
		$this->renderError(404);
	}

	/**
	 * Выполняется перед любым действием контроллера.
	 * @return boolean Должно ли выполнится действие.
	 */
	protected function beforeAction() {
		return true;
	}

	/**
	 * Выполняется после любого действия контроллера.
	 */
	protected function afterAction() {
	}

	/**
	 * Генерит страницу ошибки
	 */
	protected function renderError($code = 404) {
		switch ($code) {
			case 404:
				$this->
				exit(1);
		}
	}

	protected function renderTemplate($template) {
		App::get()->smarty->assign('CONTENT', App::get()->smarty->fetch($template));
		App::get()->smarty->display('header.tpl');
	}

}

?>
