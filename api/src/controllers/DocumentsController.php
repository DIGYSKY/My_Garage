<?php

require_once 'api/src/models/DocumentsModels.php';

class DocumentsController
{
  public static function getAllDocuments($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $offset = $params['offset'] ?? 0;
    $limit = $params['limit'] ?? 10;
    $response = new Answer();

    try {
      $documents = DocumentsModels::getAllDocuments($conn, $offset, $limit);
      $response->prepare('Documents retrieved successfully', 200, $documents);
      return $response;
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 500, null);
      return $response;
    }
  }

  public static function getDocumentById($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $id = $params['id'];

    $document = new DocumentsModels();
    $response = new Answer();
    try {
      $document->loadFromDatabase($conn, $id);
      $response->prepare('Document retrieved successfully', 200, $document);
      return $response;
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 404, null);
      return $response;
    }
  }

  public static function createDocument($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $data = $params;

    $document = new DocumentsModels();
    $document->setIdCars($data['id_cars']);
    $document->setName($data['name']);
    $document->setDescription($data['description']);
    $document->setType($data['type']);
    $document->setPath($data['path']);

    $response = new Answer();
    if ($document->save($conn)) {
      $response->prepare('Document created successfully', 201, null);
      return $response;
    } else {
      $response->prepare('Failed to create document', 500, null);
      return $response;
    }
  }

  public static function updateDocument($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $id = $params['id'];
    $data = $params;

    $document = new DocumentsModels();
    $response = new Answer();
    try {
      $document->loadFromDatabase($conn, $id);
      $document->setIdCars($data['id_cars']);
      $document->setName($data['name']);
      $document->setDescription($data['description']);
      $document->setType($data['type']);
      $document->setPath($data['path']);

      if ($document->update($conn)) {
        $response->prepare('Document updated successfully', 200, null);
        return $response;
      } else {
        $response->prepare('Failed to update document', 500, null);
        return $response;
      }
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 404, null);
      return $response;
    }
  }

  public static function deleteDocument($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $id = $params['id'];

    $document = new DocumentsModels();
    $response = new Answer();
    try {
      $document->loadFromDatabase($conn, $id);
      if ($document->delete($conn)) {
        $response->prepare('Document deleted successfully', 200, null);
        return $response;
      } else {
        $response->prepare('Failed to delete document', 500, null);
        return $response;
      }
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 404, null);
      return $response;
    }
  }
}
