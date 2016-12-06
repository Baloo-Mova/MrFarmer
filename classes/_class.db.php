<?PHP

class db{


	private $con = false; // Идентификатор
	private $Queryes = 0; // Число запросов
	private $MySQLErrors = array(); // Массив с ошибками
	private $TimeQuery = 0; // Всемя запросов
	private $MaxExTime = 0; // Максимальное время за 1 запрос
	private $ListQueryes = ""; // Список запросов
	private $HardQuery = ""; // Самый тяжелый запрос
	private $LastQuery = false; // Ресурс запрос
	private $ConnectData = array(); // Данные соединения
	
	/*======================================================================*\
	Function:	__construct
	Descriiption: Выполняется при создании экземпляра класса
	\*======================================================================*/
	public function __construct($host, $user, $pass, $base){
		$this->Connect($host, $user, $pass, $base);
		//$this->query("SET NAMES 'cp1251'");
		//$this->query("SET CHARACTER SET 'cp1251'");

        $this->query("set character_set_client='cp1251'");
        $this->query("set character_set_results='cp1251'");
        $this->query("set collation_connection='cp1251_general_ci'");
    }
	
	/*======================================================================*\
	Function:	Stats
	Descriiption: Возвращает статистику по запросам
	\*======================================================================*/
	public function Stats(){
		
		$sD = array();
		$sD["TimeQuery"] = $this->TimeQuery;
		$sD["MaxExTime"] = $this->MaxExTime;
		$sD["ListQueryes"] = $this->ListQueryes;
		$sD["HardQuery"] = $this->HardQuery;
		$sD["Queryes"] = $this->Queryes;
		return $sD;
	}

	/*======================================================================*\
	Function:	GetError
	Descriiption: Выводит описание ошибки в поток
	\*======================================================================*/
	private function GetError($TextError){
		$this->MySQLErrors[] = $TextError;
		die($TextError);
	}
	
	
	/*======================================================================*\
	Function:	query
	Descriiption: Запрос
	\*======================================================================*/	
	public function query($query, $FreeMemory = false, $write_last = true){
		
		$TimeA = $this->get_time();
		$xxt_res = mysqli_query($this->con, $query) or $this->GetError(mysqli_error($this->con));
		
		if($write_last) $this->LastQuery = $xxt_res;
		
		$TimeB = $this->get_time() - $TimeA;
		$this->TimeQuery += $TimeB;
		
			if($TimeB > $this->MaxExTime){$this->HardQuery = $query; $this->MaxExTime = $TimeB;}
			
				if( empty($this->ListQueryes) ) $this->ListQueryes = $query; else $this->ListQueryes .= "\n".$query;
			
		$this->Queryes++;
		
		if(!$FreeMemory){
			return $this->LastQuery;
		}else return $this->FreeMemory();
		
		
	}

	/*======================================================================*\
	Function:	Connect
	Descriiption: Соединяется с ДБ
	\*======================================================================*/	
	private function Connect($host, $user, $pass, $base){
		$this->con =  @mysqli_connect($host, $user, $pass, $base) or $this->GetError(mysqli_connect_error());
	} 
	
	
	/*======================================================================*\
	Function:	MultiQuery
	Descriiption: Множественный запрос
	\*======================================================================*/	
	function MultiQuery($query){
	
		$TimeA = $this->get_time();

		mysqli_multi_query($this->con, $query) or $this->GetError(mysqli_connect_error());
    	$TimeB = $this->get_time() - $TimeA;	
		$ret_data = array();
		$counter = 0;
			do{
        
				if ($result = mysqli_store_result($this->con)) {
					
					while ($row = mysqli_fetch_array($result)) {
					$ret_data[$counter][] = $row;
					}
					mysqli_free_result($result);
					$counter++;
				}

				
    		}while(mysqli_next_result($this->con));

		
		
		$this->TimeQuery += $TimeB;
			
			if($TimeB > $this->MaxExTime){$this->HardQuery = $query; $this->MaxExTime = $TimeB;}
			
				if( empty($this->ListQueryes) ) $this->ListQueryes = $query; else $this->ListQueryes .= "\n".$query;
			
		$this->Queryes++;
		
		return $ret_data;
	}
	
	/*======================================================================*\
	Function:	get_time
	Descriiption: Возвращает строку времени
	\*======================================================================*/	
	private function get_time()
	{
		list($seconds, $microSeconds) = explode(' ', microtime());
		return ((float) $seconds + (float) $microSeconds);
	}
	
	/*======================================================================*\
	Function:	__destruct
	Descriiption: Выполняется при уничтожении экземпляра класса
	\*======================================================================*/
	function __destruct(){
		
		if( !count($this->MySQLErrors) ) mysqli_close($this->con);
	
	}
	
	/*======================================================================*\
	Function:	FreeMemory
	Descriiption: Освобождает память
	\*======================================================================*/
	function FreeMemory()
	{
		$tr = ($this->LastQuery) ? true : false;
		@mysqli_free_result($this->LastQuery);
		return $tr;
	}
	
	/*======================================================================*\
	Function:	RealEscape
	Descriiption: Фильтрация )
	\*======================================================================*/
	function RealEscape($string)
	{
		if ($this->con) return mysqli_real_escape_string ($this->con, $string);
		else return mysql_escape_string($string);
	}
	
	/*======================================================================*\
	Function:	NumRows
	Descriiption: Подсчет числа строк
	\*======================================================================*/
	function NumRows()
	{
		return mysqli_num_rows($this->LastQuery);
	}
	
	/*======================================================================*\
	Function:	fetch_array
	Descriiption: Возвращ массив, создает циферные ключи...
	\*======================================================================*/
	function FetchArray(){
		//if($this->LastQuery)
		return mysqli_fetch_array($this->LastQuery);
	}
	
	/*======================================================================*\
	Function:	NumRows
	Descriiption: Возвращает результат
	\*======================================================================*/
	function FetchRow(){
		$xres = mysqli_fetch_row($this->LastQuery);
		
		return (count($xres) > 1) ? $xres :  $xres[0];
	}
	
	/*======================================================================*\
	Function:	LastInsert()
	Descriiption: Возвращает последний ID вставки
	\*======================================================================*/
	function LastInsert(){
		
		return @mysqli_insert_id($this->con);
		
	}
	/*======================================================================*\
	
	\*======================================================================*/
	function getAvatar($login) {
		$this->Query("SELECT `avatar` FROM `db_users_a` WHERE `user` = '$login'");
		$row = $this->FetchArray();
		return $row['avatar'];
	}
	
	function isSecurity($avatar) {
		$name = $avatar['name'];
		$type = $avatar['type'];
		$size = $avatar['size'];
		$blacklist = array(".php",".phtml",".php3",".php4");
		foreach ($blacklist as $item) {
			if(preg_match("/$item\$/i", $name)) return false;
		}
		if (($type != "image/gif") && ($type != "image/jpg") && ($type != "image/png")) return false;
		if (($size > 1 * 1024 * 1024)) return false;
		return true;
	}

	function loadAvatar($avatar, $login) {
		$type = $avatar['type'];
		$uploaddir = "images/avatar/";
		$name = md5(microtime()).".".substr($type, strlen("image/"));
		$uploadfile = $uploaddir.$name;
		if (move_uploaded_file($avatar['tmp_name'], $uploadfile)) {
			$this->setAvatar($login, $name);
			return true;
		}
		else return false;
	}

	function setAvatar($login, $name) {
		$this->Query("UPDATE `db_users_a` SET `avatar` = '$name' WHERE `user` = '$login'");
	}
	
	function deleteAvatar($delete, $login) {
		if($delete == 1) {
		$name = "no.png";
		$this->Query("UPDATE `db_users_a` SET `avatar` = '$name' WHERE `user` = '$login'");
		return true;
		}
		else return false;
	}
	
	function changePassword($pass, $re_pass, $login) {
		if (!$pass  || !$re_pass) return false;
		if ($pass != $re_pass) return false;
		$func = new func;
		$reset = $func->md5Password($pass);
		$this->Query("UPDATE `db_users_a` SET `pass` = '$reset' WHERE `user` = '$login'");
		return true;
	}
	
	function changeFloor($floor, $login) {
		if ($floor == 1 || $floor == 2) {
	    $this->Query("UPDATE `db_users_a` SET `floor` = '$floor' WHERE `user` = '$login'");
		return true;
		}
		else return false;
	}
	
	function cashOut($payeer, $summa, $usid, $usname) {
		$summa = intval($summa);
		if(!$summa) return false;
		$func = new func;
		if($func->ViewPurse($payeer) === false) return false;
		if(intval($summa) < 100 || intval($summa) > 200) return false;
		$this->Query("SELECT COUNT(*) FROM `db_payment` WHERE `user_id` = '$usid' AND (`status` = '0' OR `status` = '1')");
		if($this->FetchRow() != 0) return false;
		$config = new config;
		$payer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
		if ($payer->isAuth() === false) return false;
		$arBalance = $payer->getBalance();
		if($arBalance['auth_error'] != 0) return false;
		$this->Query("SELECT * FROM `db_config` WHERE `id` = '1' LIMIT 1");
		$sonfig_site = $this->FetchArray();
		$sum_pay = round(($summa / $sonfig_site['ser_per_wmr']), 2);
		$balance = $arBalance['balance']['RUB']['DOSTUPNO'];
		if($balance < $sum_pay) return false;
		
		$arTransfer = $payeer->transfer(array(
										'curIn' => 'RUB', 
										'sum' => $sum_pay, 
										'curOut' => 'RUB', 
										'to' => $payeer, // 
										'comment' => iconv('windows-1251', 'utf-8', "Выплата пользователю: {$usname} с проекта HelpMy Money")
										));
		if (empty($arTransfer["historyId"])) return false;
		$this->Query("UPDATE `db_users_b` SET `money_p` = money_p - '$summa' WHERE `id` = '$usid'");
		$da = time();
		$ppid = $arTransfer['historyId'];
		$this->Query("INSERT INTO `db_payment` (`user`, `user_id`, `purse`, `sum`, `valuta`, `serebro`, `payment_id`, `date_add`, `status`) VALUES ('$usname','$usid','$payeer','$sum_pay','RUB', '$summa','$ppid','$da', '3')");
		$this->Query("UPDATE `db_users_b` SET `payment_sum` = payment_sum + '$sum_pay' WHERE `id` = '$usid'");
		$this->Query("UPDATE `db_stats` SET `all_payments` = all_payments + '$sum_pay' WHERE `id` = '1'");
		return true;
	}
}
?>