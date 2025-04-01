<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  //get di tutti
  public function index(Request $request, Response $response, $args){
    //$mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    //$result = $mysqli_connection->query("SELECT * FROM alunni");
    //$results = $result->fetch_all(MYSQLI_ASSOC);    
    $db = Db::getInstance();
    $result = $db->select("alunni");

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //get con id
  public function view(Request $request, Response $response, $args){
    //$mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    //$result = $mysqli_connection->query('SELECT * FROM alunni WHERE id=' . $args["id"] .'');
    //$results = $result->fetch_all(MYSQLI_ASSOC);
    $db = Db::getInstance();
    $result = $db->select("alunni","id=" . $args["id"] ."");

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
  //create
  public function create(Request $request, Response $response, $args){
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("INSERT INTO alunni (nome, cognome) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['nome'], $data['cognome']);
    $stmt->execute();

    $response->getBody()->write($data["nome"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
  //update
  public function update(Request $request, Response $response, $args){
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("UPDATE alunni SET nome = ?, cognome = ? where id = ?");
    $stmt->bind_param("ssi", $data['nome'], $data['cognome'], $data['id']);
    $stmt->execute();

    $response->getBody()->write($data["nome"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
  //delete
  public function destroy(Request $request, Response $response, $args){
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("DELETE FROM alunni WHERE id = ?;");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();

    $response->getBody()->write("+1 KILL");
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
  
  //get con almeno tre lettere nome o cognome
  public function search(Request $request, Response $response, $args){
    //$mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $lettere = "'%". $args['lettere'] . "%'";
    //$result = $mysqli_connection->query("SELECT * FROM alunni WHERE (nome LIKE $lettere or cognome LIKE $lettere);");
    //$results = $result->fetch_all(MYSQLI_ASSOC);
    $db = Db::getInstance();
    $result = $db->select("alunni","(nome LIKE $lettere or cognome LIKE $lettere);");
    

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
  //per colonne
  public function sort(Request $request, Response $response, $args){
    //$mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $lettere = "'%". $args['lettere'] . "%'";
    $result = $mysqli_connection->query("describe alunni");
    $db = Db::getInstance();

    $found = false;
    $cols = $result->fetch_all(MYSQLI_ASSOC);

    foreach($cols as $col){
      if($col['Field'] == $args['col']){
        $found = true;
        break;
      }
    }

    if(!$found){
      $response->getBody()->write(json_encode(["msg" => "colonna non trovata"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
    /*$query = "SELECT * FROM alunni ORDER BY " . $args["col"] . " ASC";*/
    $result = $mysqli_connection->query("SELECT * FROM alunni ORDER BY " . $args["col"] . " ASC");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
}
?>