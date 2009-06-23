<?php
// Questo file implementa la class $db, che permette di astrarre dal database usato
// (che in questo caso è Sqlite)

class db {

	// Path del db sqlite
	private $db_file;
	
	// Oggetto SQLiteDataBase per interagire con il db
	private $db_conn;
	
	// Struttura del database, viene utilizzata per crearlo se è vuoto
	private $db_structure = "(ind INTEGER PRIMARY KEY, title TEXT, body TEXT, tags TEXT, type TEXT)";

	function __construct($db_file)
	{
		// Assumiamo che $db_file sia il database sqlite da aprire
		$this->db_file = $db_file;
		
		// Otteniamo la connessione al database per effettuare qualche
		// verifica preliminare
		$db = $this->get_connection();
		
		if( $this->num_tables() == 0 )
		{
			// Il database è vuoto, per cui ricreo la struttura standard (il nome della tabella è data)
			$db->query("CREATE TABLE data " . $this->db_structure . ";");
		}
		
		// Qui andrebbero fatti degli altri check sul database, appena sapremo che struttura deve avere.
		// Leo.
		
	}
	
	function __destruct()
	{
		// Restituiamo la connessione
		unset($this->db_conn); // è veramente il metodo corretto per farlo?
	}
	
	// Questa funzione permette di ottenere l'oggetto Sqlite
	// per interrogare il database
	function get_connection()
	{
		if(get_class($this->db_conn) != "SQLiteDatabase")
		{
			// Inizializziamo la connessione (forse andrebbe fatto un check sui permessi in scrittura).
			$this->db_conn = new SQLiteDatabase($this->db_file);
		}
		// Restituiamo l'oggetto SQLiteDatabase
		return $this->db_conn;
	}
	
	
	// Restituisce il numero di tabelle presenti nel database
	function num_tables()
	{
		$db = $this->get_connection();
		$res = $db->query("SELECT * from sqlite_master WHERE type='table'");
		return $res->numRows();
	}
	
	
}


?>

