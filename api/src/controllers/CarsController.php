<?php

class CarsController
{
  public static function getAllCars($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $offset = $params['offset'] ?? 0;
    $limit = $params['limit'] ?? 10;
    $response = new Answer();

    try {
      $cars = CarsModels::getAllCars($conn, $offset, $limit);
      $response->prepare('Cars retrieved successfully', 200, $cars);
      return $response;
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 500, null);
      return $response;
    }
  }

  public static function getCarById($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $id = $params['id'];

    $car = new CarsModels();
    $response = new Answer();
    try {
      $car->loadFromDatabase($conn, $id);
      $response->prepare('Car retrieved successfully', 200, $car);
      return $response;
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 404, null);
      return $response;
    }
  }

  public static function createCar($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $data = $params;

    $car = new CarsModels();
    $car->setLitleName($data['litle_name']);
    $car->setBrand($data['brand']);
    $car->setModel($data['model']);
    $car->setFirstRegistrationDate($data['first_registration_date']);
    $car->setPrice($data['price']);

    $response = new Answer();
    if ($car->save($conn)) {
      $response->prepare('Car created successfully', 201, null);
      return $response;
    } else {
      $response->prepare('Failed to create car', 500, null);
      return $response;
    }
  }

  public static function updateCar($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $id = $params['id'];
    $data = $params;

    $car = new CarsModels();
    $response = new Answer();
    try {
      $car->loadFromDatabase($conn, $id);
      $car->setLitleName($data['litle_name']);
      $car->setBrand($data['brand']);
      $car->setModel($data['model']);
      $car->setFirstRegistrationDate($data['first_registration_date']);
      $car->setPrice($data['price']);

      if ($car->update($conn)) {
        $response->prepare('Car updated successfully', 200, null);
        return $response;
      } else {
        $response->prepare('Failed to update car', 500, null);
        return $response;
      }
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 404, null);
      return $response;
    }
  }

  public static function deleteCar($params)
  {
    $conn = BDD::getInstance()->getBdd();
    $id = $params['id'];

    $car = new CarsModels();
    $response = new Answer();
    try {
      $car->loadFromDatabase($conn, $id);
      if ($car->delete($conn)) {
        $response->prepare('Car deleted successfully', 200, null);
        return $response;
      } else {
        $response->prepare('Failed to delete car', 500, null);
        return $response;
      }
    } catch (Exception $e) {
      $response->prepare($e->getMessage(), 404, null);
      return $response;
    }
  }
}
