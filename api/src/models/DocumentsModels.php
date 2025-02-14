<?php

class DocumentsModels implements JsonSerializable
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

  // Add JSON serialization method
  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'id_cars' => $this->id_cars,
      'name' => $this->name,
      'description' => $this->description,
      'type' => $this->type,
      'path' => $this->path,
      'updated_at' => $this->updated_at,
      'created_at' => $this->created_at
    ];
  }

  // Load documents by car ID
  public static function loadDocumentsByCarsId($conn, $id_cars)
  {
    $sql = "SELECT * FROM documents WHERE id_cars = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_cars]);

    $documents = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    $stmt->execute([$id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    // Cast parameters to integers to avoid SQL syntax errors
    $offset = (int)$offset;
    $limit = (int)$limit;

    $sql = "SELECT * FROM documents LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $documents = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

  // Update method
  public function update($conn)
  {
    $sql = "UPDATE documents SET id_cars = ?, name = ?, description = ?, type = ?, path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
      $this->id_cars,
      $this->name,
      $this->description,
      $this->type,
      $this->path,
      $this->id
    ]);
  }

  // Get all ids documents from cars id
  public function getAllIdsDocumentsFromCarsId($conn, $id_cars)
  {
    $sql = "SELECT id FROM documents WHERE id_cars = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_cars]);

    $ids = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $ids[] = $row['id'];
    }
    return $ids;
  }

  // Delete method
  public function delete($conn)
  {
    $sql = "DELETE FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$this->id]);
  }

  // Save method
  public function save($conn)
  {
    $sql = "INSERT INTO documents (id_cars, name, description, type, path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
      $this->id_cars,
      $this->name,
      $this->description,
      $this->type,
      $this->path
    ]);
  }
}
