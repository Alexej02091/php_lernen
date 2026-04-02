<?php
	//require_once( 'c_autoload.php' );
	//spl_autoload_register( 'new_autoload' );
	class dbzugriff {	  		
		private $host       = "localhost:3307";
		private	$user  	    = "root";
		private $pw    	    = "";
		private $database   = "praktikum";

		public $link;
		
		public function __construct() { }

		public function connect() {
			$fehler = "SQL-Fehler: ".$this->createFehlerText( '"mysql_connect" hat einen Fehler verursacht!' );
			//mysql_connect( $this->host , $this->user , $this->pw ) or $this->error( __LINE__, __FILE__, $fehler, mysql_error() );
			$this->link = new mysqli( $this->host , $this->user , $this->pw , $this->database );
			if ( mysqli_connect_errno() ) $this->errorInfo( __LINE__, __FILE__, $fehler, mysqli_connect_error() );
		}

		public function query( $sql ) {
			$fehler = "SQL-Fehler: " . $this->createFehlerText( $sql );
			$test   = explode( " " , strtoupper( $sql ) );
			$direkt = array( 'DROP' , 'TRUNCATE' , 'ALTER' , 'INSERT' , 'UPDATE' , 'DELETE' , 'CREATE' , 'START' , 'COMMIT' , 'ROLLBACK' );
			
			if ( in_array( $test[0] , $direkt ) ) return $this->doBefehl( $sql );
			$result = $this->link->query( $sql ) or die( __LINE__." , ".__FILE__." , $fehler , " . $this->link->error );
			//if ( $this->link->sqlstate != '00000' ) return $this->link->sqlstate;
			$anz    = $result->num_rows;
			if ( $anz == 0 ) return "";
			if ( $anz == 1 ) {
				$werte = $result->fetch_array( MYSQLI_BOTH );
				//mysql_query( "FLUSH QUERY CACHE" );
				if ( count( $werte ) == 2 ) return $werte[0];
				else return $werte;
			} else {
				$back = array();
				for ( $i = 0; $i < $anz; $i++ ) {				  
					$werte = $result->fetch_array( MYSQLI_BOTH );
					$back[] = $werte;
				}
				return $back;
			}
		}
		private function errorInfo( $line , $file , $in , $mysqlErr ) {
			$meldung  = '<!doctype html>';
			$meldung .= '<html>';
			$meldung .= '<head>';
			$meldung .= '<meta charset="utf-8">';
			$meldung .= '<title>Unbenanntes Dokument</title>';
			$meldung .= '</head>';
			$meldung .= '<body>';
			$meldung .= '<div style="position:absolute; height: 20%; width: 60%; left: 50%; top: 10%; margin-left: -30%; overflow:auto; padding: 10px; border:1px solid #000000; background-color:##DBDBEA;">';
			$meldung .= '<h1>Fehler</h1>';
			$meldung .= '<p style="color:red;">' . $mysqlErr . '</p>';
			$meldung .= '<p style="color:#999999;">Datei: ' . $file . '<br>Zeile: ' . $line . '</p>';
			$meldung .= '<p>Befehl: ' . $in . '</p>';
			$meldung .= '</div>';
			$meldung .= '</body>';
			$meldung .= '</html>';
			die( $meldung );
		}
		public function getLastId() {
			return $this->link->insert_id;
		}
		private function doBefehl( $aSQL ) {
			$fehler = "SQL-Fehler: ".$this->createFehlerText( $aSQL );
			$result = $this->link->query( $aSQL ) or die( __LINE__." , ".__FILE__." , $fehler , " . $this->link->error );
			return $result;
		}
		private function createFehlerText( $text ) {
			$back = str_replace( array( '"' , "'" ) , array( "*" , "#" ) , $text );
			return $back;
		}
		public function getString( $text ) {
			if ( empty( $text ) ) return '';
			return $this->link->real_escape_string( $text );
		}
	}
?>