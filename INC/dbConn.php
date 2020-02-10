<?php
### 서버정보
	$dbCon['dbHost'] = "dbhost";
	$dbCon['dbUid']  = "dbuser";
	$dbCon['dbPw']   = "dbpw";
	$dbCon['db']     = "dbname";
	$dbCon['charset']= "utf-8";
	$SiteName = "the_F";
//(/home/hosting_users/fw_withu/www/

class mydb {
	private $mysqli;
	private $host;
	private $user;
	private $pw;
	private $db;

	function __construct($dbCon) {
		$this->host = $dbCon['dbHost'];
		$this->user = $dbCon['dbUid'] ;
		$this->pw = $dbCon['dbPw'] ;
		$this->db = $dbCon['db'] ;
	}

	function __destruct() {
		$this->db_close();
	}

	function connect()	{
		try {
			$this->mysqli = new mysqli($this->host, $this->user, $this->pw, $this->db );
			//mysql_set_charset("set names euc-kr"); 
			if (!$this->mysqli){
				throw new Exception("Could not connect to the MySQL server.");
			}else {

              if($dbCon['charset'])  $this->mysqli->set_charset($dbCon['charset']);
			}
		} catch( Exception $con_error ) {
			echo($con_error->getMessage());
		}
	}

	function tran_query ($query)	{
		$this->connect();
		$this->mysqli->autocommit(false);
		for($i=0; $i<count($query); $i++) {
			$this->rs = @mysqli_query($this->mysqli,$query[$i]);
			if ( $this->mysqli-> error ) {
				break;
			}
		}
		if ( $this->mysqli-> error ) {
			$this->mysqli->rollback();
			return "0" ;
		} else {
			$this->mysqli->commit();
			return "1" ;
		}
	}

	function query($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		return $this->rs;
	}

	function fetch_array($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		$tempArray = array();
		$i=0;
		while( $data = @mysqli_fetch_array( $this->rs ) ) {
			$tempArray[$i] =  $data ;
			$i++;
		}
		return $tempArray ;
	}

	// 한개지정해서 뽑기
	function select_one($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		$row = $this->rs->fetch_row();
		return $row[0];
	}

    // 한개지정해서 뽑기
	function get_once($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		$row = $this->rs->fetch_row();
		return $row[0];
	}
    // 줄로뽑기
	function row($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		$row = @mysqli_fetch_array( $this->rs );
		return $row;
	}

    // 줄로뽑기2
	function fetch_row($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		$row = @mysqli_fetch_row( $this->rs );
		return $row;
	}

	//레코드 총 갯수를 구한다.
	function num_rows($query)	{
		$this->connect();
		$this->rs = @mysqli_query($this->mysqli,$query);
		$row = @mysqli_num_rows( $this->rs );
		return $row;
	}


    //마지막 insert 된 아이디 값
    function insert_id(){
        $temp_number = mysqli_insert_id($this->mysqli);
        return $temp_number;
    }

    // 디비존재여부 뽑기
    function exist($db_table_name) {
        $que = "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '".$this->db."' AND table_name = '".$db_table_name."';";
        $exist_out = $this->get_once( $que );
        return $exist_out;
    }


	function db_close() {
		if ($this->rs) {
			@mysqli_free_result( $this->rs );
		}
		if ($this->mysqli){
			@mysqli_close();
		}
	}


} /// end class

$db = new mydb($dbCon );

//인젝션대비
function escape_string ($fillter,$chk_trim="0") {
	GLOBAL $dbCon;
	if ( $chk_trim == 1 ) {
		$fillter = trim($fillter);
	}
	$link = mysqli_connect($dbCon['dbHost'], $dbCon['dbUid'], $dbCon['dbPw'], $dbCon['db']);
//	$fillter = htmlspecialchars($fillter); //html엔티티문자변환
//	$fillter = strip_tags($fillter); //html태그제거
	$fillter =  mysqli_real_escape_string($link, $fillter );
	return $fillter;
}

?>
