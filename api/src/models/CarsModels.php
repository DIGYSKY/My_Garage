<?php

class CarsModels implements JsonSerializable
{
  private $id;
  private $litle_name;
  private $brand;
  private $model;
  private $first_registration_date;
  private $price;
  private $updated_at;
  private $created_at;

  // Getters
  public function getId()
  {
    return $this->id;
  }

  public function getLitleName()
  {
    return $this->litle_name;
  }

  public function getBrand()
  {
    return $this->brand;
  }

  public function getModel()
  {
    return $this->model;
  }

  public function getFirstRegistrationDate()
  {
    return $this->first_registration_date;
  }

  public function getPrice()
  {
    return $this->price;
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
  public function setLitleName($litle_name)
  {
    $this->litle_name = $litle_name;
  }

  public function setBrand($brand)
  {
    $this->brand = $brand;
  }

  public function setModel($model)
  {
    $this->model = $model;
  }

  public function setFirstRegistrationDate($first_registration_date)
  {
    $this->first_registration_date = $first_registration_date;
  }

  public function setPrice($price)
  {
    $this->price = $price;
  }

  // Update method
  public function update($conn)
  {
    $sql = "UPDATE cars SET litle_name = ?, brand = ?, model = ?, first_registration_date = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
      $this->litle_name,
      $this->brand,
      $this->model,
      $this->first_registration_date,
      $this->price,
      $this->id
    ]);
  }

  // Delete method
  public function delete($conn)
  {
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$this->id]);
  }

  public function loadFromDatabase($conn, $id)
  {
    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $this->id = $row['id'];
      $this->litle_name = $row['litle_name'];
      $this->brand = $row['brand'];
      $this->model = $row['model'];
      $this->first_registration_date = $row['first_registration_date'];
      $this->price = $row['price'];
      $this->updated_at = $row['updated_at'];
      $this->created_at = $row['created_at'];
    } else {
      throw new Exception("Car not found with ID: $id");
    }
  }

  public static function getAllCars($conn, $offset, $limit)
  {
    // Cast parameters to integers to avoid SQL syntax errors
    $offset = (int)$offset;
    $limit = (int)$limit;

    $sql = "SELECT * FROM cars LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $cars = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $car = new CarsModels();
      $car->id = $row['id'];
      $car->litle_name = $row['litle_name'];
      $car->brand = $row['brand'];
      $car->model = $row['model'];
      $car->first_registration_date = $row['first_registration_date'];
      $car->price = $row['price'];
      $car->updated_at = $row['updated_at'];
      $car->created_at = $row['created_at'];
      $cars[] = $car;
    }

    return $cars;
  }

  public function save($conn)
  {
    $sql = "INSERT INTO cars (litle_name, brand, model, first_registration_date, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
      $this->litle_name,
      $this->brand,
      $this->model,
      $this->first_registration_date,
      $this->price
    ]);
  }

  // Add this new method for JSON serialization
  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'litle_name' => $this->litle_name,
      'brand' => $this->brand,
      'model' => $this->model,
      'first_registration_date' => $this->first_registration_date,
      'price' => $this->price,
      'updated_at' => $this->updated_at,
      'created_at' => $this->created_at
    ];
  }
}
