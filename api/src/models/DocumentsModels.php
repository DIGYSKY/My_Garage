<?php

class DocumentsModels
{
  private $id;
  private $id_cars;
  private $name;
  private $description;
  private $type;
  private $path;
  private $updated_at;
  private $created_at;

  // Getters
  public function getId()
  {
    return $this->id;
  }

  public function getIdCars()
  {
    return $this->id_cars;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getType()
  {
    return $this->type;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

  public function getCreatedAt()
  {
    return $this->created_at;
  }

  // Setters
  public function setIdCars($id_cars)
  {
    $this->id_cars = $id_cars;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function setType($type)
  {
    $this->type = $type;
  }

  public function setPath($path)
  {
    $this->path = $path;
  }

  // Load documents by car ID
  public static function loadDocumentsByCarsId($conn, $id_cars)
  {
    $sql = "SELECT * FROM documents WHERE id_cars = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cars);
    $stmt->execute();
    $result = $stmt->get_result();

    $documents = [];
    while ($row = $result->fetch_assoc()) {
      $document = new DocumentsModels();
      $document->id = $row['id'];
      $document->id_cars = $row['id_cars'];
      $document->name = $row['name'];
      $document->description = $row['description'];
      $document->type = $row['type'];
      $document->path = $row['path'];
      $document->updated_at = $row['updated_at'];
      $document->created_at = $row['created_at'];
      $documents[] = $document;
    }

    return $documents;
  }

  // Load a specific document by ID
  public function loadFromDatabase($conn, $id)
  {
    $sql = "SELECT * FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      $this->id = $row['id'];
      $this->id_cars = $row['id_cars'];
      $this->name = $row['name'];
      $this->description = $row['description'];
      $this->type = $row['type'];
      $this->path = $row['path'];
      $this->updated_at = $row['updated_at'];
      $this->created_at = $row['created_at'];
    } else {
      throw new Exception("Document not found with ID: $id");
    }
  }

  public static function getAllDocuments($conn, $offset, $limit)
  {
    $sql = "SELECT * FROM documents LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
  }

  // Update method
  public function update($conn)
  {
    $sql = "UPDATE documents SET id_cars = ?, name = ?, description = ?, type = ?, path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $this->id_cars, $this->name, $this->description, $this->type, $this->path, $this->id);
    return $stmt->execute();
  }

  // Get all ids documents from cars id
  public function getAllIdsDocumentsFromCarsId($conn, $id_cars)
  {
    $sql = "SELECT id FROM documents WHERE id_cars = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cars);
    $stmt->execute();
    $result = $stmt->get_result();
    $ids = [];
    while ($row = $result->fetch_assoc()) {
      $ids[] = $row['id'];
    }
    return $ids;
  }

  // Delete method
  public function delete($conn)
  {
    $sql = "DELETE FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $this->id);
    return $stmt->execute();
  }

  // Save method
  public function save($conn)
  {
    $sql = "INSERT INTO documents (id_cars, name, description, type, path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $this->id_cars, $this->name, $this->description, $this->type, $this->path);
    return $stmt->execute();
  }
}
