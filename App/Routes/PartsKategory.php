<?php

namespace App\Routes;

use PDO;
use PDOException;

use Slim\Slim;
use App\Db\Connection;

class PartsKategory {
    
	function index() {
		$app = Slim::getInstance();
		
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM parts_kategory");
			$sth->execute();
	 
			$parts = $sth->fetchAll(PDO::FETCH_OBJ);
	 
			if($parts) {
				$app->response->setStatus(200);
				$app->response()->headers->set('Content-Type', 'application/json');
				echo json_encode($parts);
			} else {
				throw new PDOException('No records found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function view($id) {
		$app = Slim::getInstance();
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM parts_kategory WHERE id = :id");
			$sth->bindParam('id', $id);
			$sth->execute();
	 
			$parts = $sth->fetch(PDO::FETCH_OBJ);
	 
			if($parts) {
				$app->response->setStatus(200);
				$app->response()->headers->set('Content-Type', 'application/json');
				echo json_encode($parts);
			} else {
				throw new PDOException('Data not found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	
	function create() {
		$app = Slim::getInstance();
		
        $request = $app->request->post();
		$nama_category = $request['nama_category'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("INSERT INTO parts_kategory (`nama_kategory`) VALUES (:nama_category)");
 
			$sth->bindParam('nama_category', $nama_category);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->response()->headers->set('Content-Type', 'application/json');
			echo json_encode(array("status" => "success", "code" => 1));
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function update($id) {
		$app = Slim::getInstance();
		
        $request = $app->request->put();
		$nama_category = $request['nama_category'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("UPDATE parts_kategory SET nama_kategory = :nama_category
			WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$sth->bindParam('nama_category', $nama_category);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->response()->headers->set('Content-Type', 'application/json');
			echo json_encode(array("status" => "success", "code" => 1));
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function delete($id) {
		$app = Slim::getInstance();
		        
		try {
			$db = new Connection();
			$sth = $db->prepare("DELETE FROM parts_kategory WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->response()->headers->set('Content-Type', 'application/json');
			echo json_encode(array("status" => "success", "code" => 1));
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}	
}