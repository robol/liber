<?php
// Questo file implementa la class $db, che permette di astrarre dal database usato
// (che in questo caso è Sqlite)

// I post vengono restituiti (e in generale trattati) come un array strutturato 
// nel modo seguente:

/*
 *			post = array( "id" , "title" , "body", "date" , "tags" )
 *			
 *			dove:
 *				post["id"] = id del post
 *				post["title"] = "Titolo del post
 *				post["body"] = "Corpo del post"
 *				post["date"] = 2009-06-24 (ad esempio)
 *				post["tags"] = array( tag1, tag2, tag3, ... )
 */
 
 // Convenzioni di nomenclatura:
 
 /*
 	* Le funzioni si dividono in:
 	* 
 	* Tipo 1) Funzioni che il programma principale non dovrebbe usare, ad esempio select(), che è di "basso livello"
 	*					e non è destinata all'uso "interattivo", ma è solo di comodo per l'implementazione della classe
 	*	Tipo 2) Funzioni destinate ad ottenere UN post, che cominciano con get_post_by_*($param)					
 	* Tipo 3) Funzioni destinate ad ottenre UNA LISTA di post, che cominciano con get_posts_by_*($param) [1]
 	* Tipo 4) Funzioni destinate ad aggiornare e/o creare post, che devo ancora decidere come si chiameranno. :)
 	*
 	*	Nota [1]: Le funzioni che restituiscono una lista restituiscono una lista di elementi (id, title) che poi permettono di 
 	* recuperare i veri post con le funzioni di tipo 2).
 	*
 	*/

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
	
	// Esegue un select sulla tabella data del db, quella dove si trovano tutte la pagine
	// e restituisce l'oggeto sqlite_resp su cui fare fetch() per ottenere i dati.
	// $cond è la parte da mettere nel WHERE.
	function select($cond)
	{
		$db = $this->get_connection();
		$query = "SELECT * from data WHERE " . $cond . ";" ;
		return $db->query($query);
	}
	
	
	// Restituisce il numero di tabelle presenti nel database
	function num_tables()
	{
		$db = $this->get_connection();
		$res = $db->query("SELECT * from sqlite_master WHERE type='table'");
		return $res->numRows();
	}
	
	// Ottiene un post (nel senso generale di pagina) dando l'id e il type
	// In questo modo si ottiene un post unico!
	// Restituisce 404 nel caso di post non trovato, -1 in caso di errore generico.
	function get_post_by_id($id, $type)
	{
		$cond = "type = '$type' AND id='$id';";
		$res = $this->select($cond);
		
		// Qualche controllo di integrità
		if( $res->numRows() == 0)
			return 404 // Non abbiamo trovato il post!
		elseif( $res->numRows() > 1 )
			return -1 // Ci sono troppi post con questo id! -- in realtà dovrebbe essere impossibile
			
		$post = $res->fetch();
		
		// Questa parte non è strettamente necessaria, ma almeno sarà comoda da modificare se dovesse
		// cambiare la struttura del database.
		$ret["title"] = $post["title"];
		$ret["body"] = $post["body"];
		$ret["date"] = $post["date"];
		$ret["tags"] = $post["tags"].explode(",");
		return $ret;
	}
	
	
	
	
}


?>

