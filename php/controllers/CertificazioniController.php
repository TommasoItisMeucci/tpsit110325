<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController
{

  //get con id
  public function view(Request $request, Response $response, $args){
    //$mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    //$result = $mysqli_connection->query('SELECT * FROM alunni WHERE id=' . $args["id"] .'');
    //$results = $result->fetch_all(MYSQLI_ASSOC);
    $db = Db::getInstance();
    $result = $db->select("certificazioni","alunno_id=" . $args["id"] ."");

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //get con id e id cert
  public function search(Request $request, Response $response, $args){
    //$mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    //$result = $mysqli_connection->query('SELECT * FROM alunni WHERE id=' . $args["id"] .'');
    //$results = $result->fetch_all(MYSQLI_ASSOC);
    $db = Db::getInstance();
    $result = $db->select("certificazioni","alunno_id=" . $args["id"] . " AND id=" . $args["cert_id"]);

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
}
?>