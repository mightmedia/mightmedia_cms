<?php

class Routes {
	public $routes = [];

	public $headerData = [];

	private $routeParts = [];

	private $requestUrlParts = [];

	private $name;

	private $vars = [];

	public $methods = [
		'get',
		'post',
		'put',
		'patch',
		'delete'
	];
	
	public function __construct() {

		

		$route = [
			'gods' => [
				'method'	=> 'get',
				'route'		=> '',
				'include'	=> null,
				'callback'	=> '',
				'root'		=> false,
				'data'		=> null,
				'header'	=> null,
			]
		];

		
	}

	public function newRoute($name, $params)
	{
		$this->setRoutes($name, $params);		
		$this->route($name);
	}

	public function setRoutes($name, $params)
	{
		// foreach ($params as $key => $value) {
		// 	// check if route with same name exists
		// 	if(! empty($this->routes[$key])) {
		// 		throw new Exception('Error: route with name ' . $key . ' already exists!');
		// 	// if not - set the new route
		// 	} else {
		// 		// $this->routes[$key] = $value;
		// 		$this->setRoute($key, $value);
		// 	}
		// }

		$this->setRoute($name, $params);
	}

	private function checkMethod($method)
	{
		return $_SERVER['REQUEST_METHOD'] == strtoupper($method);
	}

	public function routeAjax($route)
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT'){

			$routeCheck 		= routeCheck($route);
			$routeParts 		= $routeCheck['routeParts'];
			$requestUrlParts	= $routeCheck['requestUrlParts'];

			if(count($routeParts) != count($requestUrlParts)){
				
				return false;
			}
			
			$routeParam = [];

			for($i = 0; $i < count($routeParts); $i++){
				$routePart = $routeParts[$i];
			
				if(preg_match("/^[$]/", $routePart)) {
					$routePart = ltrim($routePart, '$');
					// set params
					array_push($routeParam, $requestUrlParts[$i]);
					// set route data
					$routePart = $requestUrlParts[$i];
					

				} else if($routeParts[$i] != $requestUrlParts[$i]){

					return false;
				} 
			}

			$action = 'ajax' . ucfirst($routePart);

			include ROOT . 'core/inc/inc.ajax.php';

			exit;
		}    
	}

	public function any($route, $pathToInclude)
	{
		$this->route($route, $pathToInclude);
	}

	private function routeCheck($route)
	{
		$requestUrl			= filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
		$requestUrl			= rtrim($requestUrl, '/');
		$requestUrl			= strtok($requestUrl, '?');
		$routeParts			= explode('/', $route);
		$requestUrlParts	= explode('/', $requestUrl);

		array_shift($routeParts);
		array_shift($requestUrlParts);

		$this->routeParts 		= $routeParts;
		$this->requestUrlParts 	= $requestUrlParts;
	}

	private function checkSymbol($routeParts)
	{
		foreach($routeParts as $k => $v) {
			if(preg_match("/-/", $v)) {
				$moreRouteParts = explode('-', $v);

				// $routeParts += $moreRouteParts;
				foreach($moreRouteParts as $kM => $vM) {
					array_push($routeParts, $vM);
				}
				
				unset($routeParts[$k]);
			}
		}

		array_shift($routeParts);

		return $routeParts;
	}

	public function loadData()
	{
		if(empty($this->name)) {
			return [];
		}
		// loadRoute
		$data = $this->getRoute($this->name);

		return isset($data['header']) && ! empty($data['header']) ? $data['header'] : [];
	}

	private function dbQuery($data)
	{
		if(isset($data['query']) && ! empty($data['query'])) {	

			$this->getQueryData($data['query']);

		} elseif(isset($data['queries']) && ! empty($data['queries'])) {	

			foreach ($data['queries'] as $query) {
				$this->getQueryData($query);
			}

		}

		return false;
	}

	private function getQueryData($query)
	{
		// where
		if(isset($query['where'])) {

			foreach ($query['where'] as $kWhere => $vWhere) {
				// if i need get params from url to where closure
				if(preg_match("/^param/", $vWhere)) {
					$where = ltrim($vWhere, '.param');
					$query['where'][$kWhere] = $this->vars[$where];
				}
			}

		}

		// pagination
		if(isset($query['pagination']) && $query['pagination']) {
			// load data from DB
			$page = isset($this->vars['page']) ? (int)$this->vars['page'] : 1;

			// TODO: add to config default pagination
			$limit = isset($query['limit']) ? $query['limit'] : 2;

			$offset = $limit * ($page - 1);

			$totalRows = dbCount(
				$query['table'],
				'id'
			);
	
			$this->vars['totalPages'] = ceil($totalRows / $limit);
			$this->vars['page'] = $page;
		} else {
			$limit = isset($query['row']) && $query['row'] ? 1 : 0;
			$offset = null;
		}


		// get data
		if(isset($query['row']) && $query['row']) {
			$getData = dbRow(
				$query['table'],
				isset($query['where']) ? $query['where'] : null,
				isset($query['columns']) ? $query['columns'] : null
			);	
		} else {
			$getData = dbSelect(
				$query['table'],
				isset($query['where']) ? $query['where'] : null,
				isset($query['columns']) ? $query['columns'] : null,
				$limit,
				$offset,
				isset($query['join']) ? $query['join'] : null
			);	
		}

		// if seted `as`
		if(isset($query['as']) && ! empty($query['as'])) {
			$this->vars[$query['as']] = $getData;
		} else {
			$this->vars[$query['table']] = $getData;
		}
	}

	public function loadPages() 
	{
		
		$data = $this->getRoute($this->name);

		if($data['method'] == 'get') {
			if($query = $this->dbQuery($data)) {
				// todo
			}

			if(isset($data['data']) && ! empty($data['data'])) {
				$this->vars = array_merge($data['data'], $this->vars);
			}
			// set variables
			foreach ($this->vars as $kViewData => $VviewData) {
				// create var
				${$kViewData} = $VviewData;
				
			}

			if(isset($data['include']) && ! empty($data['include'])) {
				// file_exists()
				include_once $this->includePage($data['include']);
			} else {
				// is_callable
				call_user_func($data['callback']);
			}
		} else {
			// is_callable
			call_user_func($data['callback'], $this->dbQuery($data));
		}

		
	}

	private function loadPage($name)
	{
		$this->name = $name;
		addAction('loadPages', [$this, 'loadPages']);
	}


	private function loadPageData($name)
	{
		// $this->name = $name;
		addFilter('loadRoute', [$this, 'loadData']);
	}

	// todo: add group option
	public function route($name)
	{
				// 'method'	=> 'get',
				// 'route'		=> 'get',
				// 'include'	=> null,
				// 'callback'	=> '',
				// 'root'		=> false,
				// 'data'		=> null,
				// 'header'	=> null,

		$data = $this->getRoute($name);

		if(! $this->checkMethod($data['method'])){
			return;
		}

		//
		if($data['method'] == 'get') {
			$this->loadPageData($name);
		}
		//

		if($name == '404'){
			$this->loadPage($name);
			// todo: exit or smth
		}
		// check the route
		$this->routeCheck($data['route']);

		if($this->routeParts[0] == '' && count($this->requestUrlParts) == 0){

			$this->loadPage($name);
			
		}

		if(count($this->routeParts) != count($this->requestUrlParts)){
			
			return;
		}
		
		$routeParam = [];

		for($i = 0; $i < count($this->routeParts); $i++){
		
			if(preg_match("/^[$]/", $this->routeParts[$i])) {
				// set params
				$routePart = ltrim($this->routeParts[$i], '$');

				if(preg_match("/-/", $this->routeParts[$i])) {
					$moreRouteParts = explode('-', $this->routeParts[$i]);
					$moreRequestParts = explode('-', $this->requestUrlParts[$i], count($moreRouteParts));

					for ($iM=0; $iM < count($moreRouteParts); $iM++) { 
						$vM = $moreRequestParts[$iM];
						array_push($routeParam, $vM);

						$this->routeParts[] = $vM;
						$this->requestUrlParts[] = $vM;

						$key = ltrim($moreRouteParts[$iM], '$');

						$this->vars[$key] = $vM;
					}

				} else {
					array_push($routeParam, $this->requestUrlParts[$i]);
					
					$this->vars += [
						$routePart		=> $this->requestUrlParts[$i],
					];

				}				

				$this->vars += [
					'routeParam'	=> $routeParam,
					'routePart'		=> $this->requestUrlParts[$i],
				];

			} else if($this->routeParts[$i] != $this->requestUrlParts[$i]){

				return;
			} 
		}

		$this->loadPage($name);
	}

	private function includePage($file)
	{
		if(file_exists($file)) {
			return $file;
			// exit;
		} else {
			die('File: <strong>' . $file . '</strong> not found!');
		}
	}

	public function out($text)
	{
		echo htmlspecialchars($text);
	}

	public function getRoute($name, $params = [])
	{
		
		$route = $this->routes[$name];

		if(! empty($params)) {
			$routeParts	= explode('/', $route['route']);
			$routeParts	= $this->checkSymbol($routeParts);

			for($i = 0; $i < count($routeParts); $i++){
				$routePart = $routeParts[$i];
			
				if(preg_match("/^[$]/", $routePart)) {
					$routePart = ltrim($routePart, '$');

					if(isset($params[$routePart])) {
						$route['route'] = str_replace('$' . $routePart, $params[$routePart], $route['route']);
					}
				}
			}
		}

		return $route;
	}

	public function setHeaderData($headerData)
	{
		$headerData += $this->headerData;

		return $headerData;
	}

	public static function getHeaderData()
	{

		return self::$headerData;
	}

	public function getRouteUrl($name, $params = [])
	{
		$data = $this->getRoute($name, $params);

		return $data['route'];
	}

	public function setRoute($name, $data)
	{
		if(! in_array($data['method'], $this->methods)) {
			throw new Exception('Error: route method doesn\'t exists: ' . $data['method']);

			return;
		}

		$this->routes[$name] = $data;
	}
}