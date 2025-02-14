<?php

class CarsModels
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
    $stmt->bind_param("ssssii", $this->litle_name, $this->brand, $this->model, $this->first_registration_date, $this->price, $this->id);
    return $stmt->execute();
  }

  // Delete method
  public function delete($conn)
  {
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $this->id);
    return $stmt->execute();
  }

  public function loadFromDatabase($conn, $id)
  {
    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
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
    $sql = "SELECT * FROM cars LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $cars = [];
    while ($row = $result->fetch_assoc()) {
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
    $stmt->bind_param("ssssi", $this->litle_name, $this->brand, $this->model, $this->first_registration_date, $this->price);
    return $stmt->execute();
  }
}
